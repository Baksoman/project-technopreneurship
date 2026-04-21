<?php

namespace App\Services;

use App\Models\Component;
use App\Models\CompatibilityRule;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;
use Illuminate\Support\Collection;

class BuildRecommenderService
{
    const REQUIRED_CATEGORIES = ['cpu', 'motherboard', 'ram', 'storage', 'psu', 'cpu-cooler', 'case'];
    const ANCHOR_CATEGORIES = ['cpu', 'gpu', 'motherboard'];
    const SUPPORT_CATEGORIES = ['ram', 'storage', 'psu', 'cpu-cooler', 'case'];

    const ANCHOR_ALLOCATION = [
        'gaming' => ['gpu' => 45, 'cpu' => 35, 'motherboard' => 20],
        'editing' => ['cpu' => 50, 'gpu' => 25, 'motherboard' => 25],
        'work' => ['cpu' => 50, 'motherboard' => 30, 'gpu' => 20],
        'study' => ['cpu' => 55, 'motherboard' => 35, 'gpu' => 10],
    ];

    const SUPPORT_MIN_SCORE = [
        'ram' => 60,
        'storage' => 65,  // Naikkan dari 55 → 65 (hindari HDD lemot)
        'psu' => 50,
        'cpu-cooler' => 60,
        'case' => 70,
    ];

    /**
     * Jumlah variasi build yang di-generate sebelum dipilih yang terbaik
     */
    const CANDIDATE_BUILDS = 5;

    public function __construct(
        protected ComponentScorer $scorer,
        protected BottleneckAnalyzer $bottleneckAnalyzer,
    ) {
    }

    public function recommend(
        int $budget,
        string $useCase,
        string $brandPreference = 'any',
        bool $includeGpu = true,
        bool $includePsu = true,
        string $mode = 'balanced'
    ): array {
        // Tentukan kategori aktif
        $anchorCategories = array_values(array_diff(
            self::ANCHOR_CATEGORIES,
            $includeGpu ? [] : ['gpu']
        ));
        $supportCategories = array_values(array_diff(
            self::SUPPORT_CATEGORIES,
            $includePsu ? [] : ['psu']
        ));

        // STEP 1 — Pilih support components (tidak boleh melebihi budget)
        [$supportComponents, $supportCost, $supportFailed] = $this->pickSupportComponents(
            categories: $supportCategories,
            totalBudget: $budget,
            mode: $mode,
        );

        if (!empty($supportFailed)) {
            return $this->buildFailResponse($budget, $useCase, $mode, $supportFailed, $supportComponents, 'support');
        }

        // STEP 2 — Sisa budget untuk anchor, pastikan tidak negatif
        $anchorBudget = $budget - $supportCost;

        if ($anchorBudget <= 0) {
            return $this->buildFailResponse($budget, $useCase, $mode, $anchorCategories, $supportComponents, 'no_anchor_budget');
        }

        // STEP 3 — Generate beberapa kandidat build anchor
        $candidateBuilds = $this->generateCandidateBuilds(
            anchorCategories: $anchorCategories,
            anchorBudget: $anchorBudget,
            useCase: $useCase,
            brandPreference: $brandPreference,
            mode: $mode,
        );

        if (empty($candidateBuilds)) {
            return $this->buildFailResponse($budget, $useCase, $mode, $anchorCategories, $supportComponents, 'anchor');
        }

        // STEP 4 — Gabungkan setiap kandidat dengan support components
        //          Lalu pilih build terbaik berdasarkan mode
        $bestBuild = $this->selectBestBuild(
            candidateBuilds: $candidateBuilds,
            supportComponents: $supportComponents,
            useCase: $useCase,
            budget: $budget,
            mode: $mode,
        );

        if (!$bestBuild) {
            return $this->buildFailResponse($budget, $useCase, $mode, $anchorCategories, $supportComponents, 'anchor');
        }

        return $bestBuild;
    }

    // =========================================================================
    // SUPPORT COMPONENTS
    // =========================================================================

    protected function pickSupportComponents(
        array $categories,
        int $totalBudget,
        string $mode,
    ): array {
        $selected = [];
        $totalCost = 0;
        $failed = [];

        // Dynamic cap berdasarkan budget tier
        if ($totalBudget >= 20_000_000) {
            $capPct = $mode === 'max_budget' ? 0.20 : 0.25;
        } else if ($totalBudget >= 15_000_000) {
            $capPct = $mode === 'max_budget' ? 0.22 : 0.26;
        } else {
            $capPct = $mode === 'max_budget' ? 0.25 : 0.28;
        }
        
        $supportBudgetCap = $totalBudget * $capPct;

        foreach ($categories as $slug) {
            $baseMinScore = self::SUPPORT_MIN_SCORE[$slug] ?? 50;
            
            // Dynamic min score: turun di budget rendah
            if ($totalBudget < 15_000_000) {
                $minScore = max($baseMinScore - 10, 45);
            } else if ($totalBudget < 18_000_000) {
                $minScore = max($baseMinScore - 5, 50);
            } else {
                $minScore = $baseMinScore;
            }
            
            $candidate = $this->pickSupportCandidate($slug, $minScore, $mode);

            if (!$candidate) {
                // Fallback: turunkan threshold 10 poin
                $candidate = $this->pickSupportCandidate($slug, max($minScore - 10, 40), $mode);
            }

            if (!$candidate) {
                $candidate = $this->pickCheapestSupport($slug);
            }

            if (!$candidate) {
                $failed[] = $slug;
                continue;
            }

            if (($totalCost + $candidate->base_price) > $supportBudgetCap) {
                $cheaper = $this->pickCheapestSupport($slug);
                if ($cheaper && ($totalCost + $cheaper->base_price) <= $supportBudgetCap) {
                    // Cek apakah cheaper masih memenuhi min score
                    if ($cheaper->performance_score >= ($minScore - 10)) {
                        $candidate = $cheaper;
                    } else if ($mode === 'max_budget') {
                        // Max budget: tetap pakai yang memenuhi min score meski over cap sedikit
                        if (($totalCost + $candidate->base_price) <= $supportBudgetCap * 1.15) {
                            // Keep candidate
                        } else {
                            $candidate = $cheaper;
                        }
                    }
                }
            }

            if ($candidate->base_price > $totalBudget) {
                $failed[] = $slug;
                continue;
            }

            $selected[$slug] = $candidate->load([
                'category',
                'prices' => fn($q) => $q->where('is_available', true)->orderBy('price'),
            ]);
            $totalCost += $candidate->base_price;
        }

        return [$selected, $totalCost, $failed];
    }

    protected function pickSupportCandidate(string $slug, int $minScore, string $mode): ?Component
    {
        $query = Component::whereHas('category', fn($q) => $q->where('slug', $slug))
            ->where('is_active', true)
            ->where('performance_score', '>=', $minScore);

        if ($mode === 'max_budget') {
            return $query->orderByDesc('performance_score')->first();
        }

        // Balanced: paling worth it (score / harga)
        return $query->get()
            ->sortByDesc(fn($c) => $c->performance_score / max($c->base_price, 1))
            ->first();
    }

    protected function pickCheapestSupport(string $slug): ?Component
    {
        return Component::whereHas('category', fn($q) => $q->where('slug', $slug))
            ->where('is_active', true)
            ->orderBy('base_price')
            ->first();
    }

    // =========================================================================
    // GENERATE CANDIDATE BUILDS
    // Buat beberapa variasi kombinasi anchor components dalam budget
    // =========================================================================

    protected function generateCandidateBuilds(
        array $anchorCategories,
        float $anchorBudget,
        string $useCase,
        string $brandPreference,
        string $mode,
    ): array {
        $allocation = self::ANCHOR_ALLOCATION[$useCase] ?? self::ANCHOR_ALLOCATION['gaming'];

        // DYNAMIC ALLOCATION: Adjust berdasarkan budget tier
        if ($anchorBudget < 15_000_000 && $useCase === 'gaming') {
            $allocation = ['gpu' => 50, 'cpu' => 30, 'motherboard' => 20];
        }

        $activeAlloc = array_filter($allocation, fn($slug) => in_array($slug, $anchorCategories), ARRAY_FILTER_USE_KEY);
        $totalPct = array_sum($activeAlloc);
        $normalized = array_map(fn($pct) => ($pct / $totalPct) * 100, $activeAlloc);

        // STRATEGY: Generate kandidat dengan berbagai variasi alokasi budget
        $allBuilds = [];
        
        // Variasi 1: Alokasi standar
        $allBuilds = array_merge($allBuilds, $this->generateWithAllocation($anchorCategories, $anchorBudget, $normalized, $brandPreference, $mode));
        
        // Variasi 2: Untuk gaming, coba alokasi GPU lebih besar (jika belum)
        if ($useCase === 'gaming' && in_array('gpu', $anchorCategories) && $anchorBudget >= 15_000_000) {
            $gpuFocused = ['gpu' => 50, 'cpu' => 30, 'motherboard' => 20];
            $activeGpu = array_filter($gpuFocused, fn($slug) => in_array($slug, $anchorCategories), ARRAY_FILTER_USE_KEY);
            $totalGpu = array_sum($activeGpu);
            $normalizedGpu = array_map(fn($pct) => ($pct / $totalGpu) * 100, $activeGpu);
            $allBuilds = array_merge($allBuilds, $this->generateWithAllocation($anchorCategories, $anchorBudget, $normalizedGpu, $brandPreference, $mode));
        }
        
        // Variasi 3: Balanced allocation (33-33-33)
        if (count($anchorCategories) === 3) {
            $balanced = array_fill_keys($anchorCategories, 33.33);
            $allBuilds = array_merge($allBuilds, $this->generateWithAllocation($anchorCategories, $anchorBudget, $balanced, $brandPreference, $mode));
        }

        // Deduplicate berdasarkan kombinasi component IDs
        $unique = [];
        foreach ($allBuilds as $build) {
            $key = implode('-', array_map(fn($c) => $c->id, $build));
            $unique[$key] = $build;
        }

        return array_values($unique);
    }

    protected function generateWithAllocation(
        array $anchorCategories,
        float $anchorBudget,
        array $normalized,
        string $brandPreference,
        string $mode,
    ): array {
        $candidatesPerSlug = [];
        foreach ($normalized as $slug => $percentage) {
            $slugBudget = ($percentage / 100) * $anchorBudget;

            $candidatesPerSlug[$slug] = $this->getAnchorCandidatesStrict(
                slug: $slug,
                budget: $slugBudget,
                brandPreference: $brandPreference,
                mode: $mode,
                limit: self::CANDIDATE_BUILDS,
            );

            if ($candidatesPerSlug[$slug]->isEmpty()) {
                return [];
            }
        }

        return $this->combineCandidates($candidatesPerSlug, $anchorBudget, $normalized);
    }

    /**
     * Ambil top-N komponen dalam budget strict (tidak boleh over budget sama sekali)
     */
    protected function getAnchorCandidatesStrict(
        string $slug,
        float $budget,
        string $brandPreference,
        string $mode,
        int $limit,
    ): Collection {
        $query = Component::whereHas('category', fn($q) => $q->where('slug', $slug))
            ->where('is_active', true)
            ->where('base_price', '<=', $budget);

        if ($brandPreference !== 'any' && in_array($slug, ['cpu', 'gpu'])) {
            $brandQuery = clone $query;
            $brandQuery->where('brand', $brandPreference);

            if ($brandQuery->count() > 0) {
                $query = $brandQuery;
            }
        }

        if ($mode === 'max_budget') {
            // Max budget: ambil yang score tinggi tapi tetap pertimbangkan balance
            // Ambil top candidates lalu diversifikasi untuk hindari bottleneck
            $all = $query->orderByDesc('performance_score')->limit($limit * 3)->get();
            
            // Ambil mix: top performers + mid-range untuk variasi
            $top = $all->take((int)ceil($limit * 0.6)); // 60% top
            $mid = $all->slice((int)ceil($limit * 0.6))->take((int)ceil($limit * 0.4)); // 40% mid
            
            return $top->merge($mid)->take($limit)->values();
        }

        // Balanced: campuran score & price efficiency
        return $query->orderByDesc('performance_score')->limit($limit * 2)->get()
            ->sortByDesc(fn($c) => $c->performance_score / max($c->base_price / 1_000_000, 0.1))
            ->take($limit)
            ->values();
    }

    /**
     * Kombinasikan kandidat dari tiap slug menjadi beberapa build lengkap
     * Setiap build = 1 komponen per slug, dipilih bergantian (round-robin)
     */
    protected function combineCandidates(
        array $candidatesPerSlug,
        float $anchorBudget,
        array $normalized,
    ): array {
        $builds = [];
        $slugs = array_keys($candidatesPerSlug);
        $maxLen = max(array_map(fn($c) => $c->count(), $candidatesPerSlug));

        // FLEXIBLE COMBINATION: Coba berbagai kombinasi, tidak hanya round-robin
        // Ini penting untuk budget pas-pasan agar bisa realokasi budget antar komponen
        
        for ($i = 0; $i < min($maxLen, self::CANDIDATE_BUILDS * 2); $i++) {
            // Strategy 1: Round-robin standar
            $build = $this->tryBuildCombination($candidatesPerSlug, $slugs, $i, $anchorBudget);
            if ($build) $builds[] = $build;
            
            // Strategy 2: Prioritas GPU (untuk gaming)
            if (isset($candidatesPerSlug['gpu'])) {
                $build = $this->tryBuildWithPriority($candidatesPerSlug, $slugs, 'gpu', $i, $anchorBudget);
                if ($build) $builds[] = $build;
            }
            
            // Strategy 3: Prioritas CPU (untuk editing/work)
            if (isset($candidatesPerSlug['cpu'])) {
                $build = $this->tryBuildWithPriority($candidatesPerSlug, $slugs, 'cpu', $i, $anchorBudget);
                if ($build) $builds[] = $build;
            }
        }

        // Deduplicate & filter bottleneck ekstrem
        $unique = [];
        foreach ($builds as $build) {
            if ($this->hasExtremeBottleneck($build)) continue;
            
            $key = implode('-', array_map(fn($c) => $c->id, $build));
            $unique[$key] = $build;
        }

        return array_values($unique);
    }

    protected function tryBuildCombination(array $candidatesPerSlug, array $slugs, int $index, float $budget): ?array
    {
        $build = [];
        $cost = 0;

        foreach ($slugs as $slug) {
            $candidates = $candidatesPerSlug[$slug];
            $component = $candidates->get($index) ?? $candidates->last();

            if (!$component) return null;

            if (($cost + $component->base_price) > $budget) {
                // Coba yang lebih murah
                $component = $candidates->first();
                if (!$component || ($cost + $component->base_price) > $budget) {
                    return null;
                }
            }

            $build[$slug] = $component;
            $cost += $component->base_price;
        }

        return empty($build) ? null : $build;
    }

    protected function tryBuildWithPriority(array $candidatesPerSlug, array $slugs, string $prioritySlug, int $index, float $budget): ?array
    {
        $build = [];
        $cost = 0;

        // Pilih komponen prioritas dulu (ambil yang lebih bagus)
        if (!isset($candidatesPerSlug[$prioritySlug])) return null;
        
        $priorityCandidates = $candidatesPerSlug[$prioritySlug];
        $priorityComponent = $priorityCandidates->get($index) ?? $priorityCandidates->last();
        
        if (!$priorityComponent || $priorityComponent->base_price > $budget * 0.6) return null;
        
        $build[$prioritySlug] = $priorityComponent;
        $cost += $priorityComponent->base_price;
        $remaining = $budget - $cost;

        // Isi komponen lainnya dengan sisa budget
        foreach ($slugs as $slug) {
            if ($slug === $prioritySlug) continue;
            
            $candidates = $candidatesPerSlug[$slug];
            
            // Cari komponen terbaik yang fit di sisa budget
            $component = null;
            foreach ($candidates as $candidate) {
                if ($candidate->base_price <= $remaining) {
                    $component = $candidate;
                    break;
                }
            }
            
            if (!$component) {
                $component = $candidates->sortBy('base_price')->first();
            }
            
            if (!$component || ($cost + $component->base_price) > $budget) {
                return null;
            }

            $build[$slug] = $component;
            $cost += $component->base_price;
            $remaining = $budget - $cost;
        }

        return count($build) === count($slugs) ? $build : null;
    }

    protected function hasExtremeBottleneck(array $build): bool
    {
        $cpu = $build['cpu'] ?? null;
        $gpu = $build['gpu'] ?? null;
        
        if (!$cpu || !$gpu) return false;
        
        $gap = abs(($cpu->performance_score ?? 0) - ($gpu->performance_score ?? 0));
        return $gap > 40; // Tolak kombinasi dengan gap ekstrem
    }

    // =========================================================================
    // SELECT BEST BUILD
    // Dari semua kandidat build, pilih yang paling optimal
    // =========================================================================

    protected function selectBestBuild(
        array $candidateBuilds,
        array $supportComponents,
        string $useCase,
        int $budget,
        string $mode,
    ): ?array {
        $evaluated = [];

        foreach ($candidateBuilds as $anchorBuild) {
            $loadedAnchor = [];
            foreach ($anchorBuild as $slug => $component) {
                $loadedAnchor[$slug] = $component->load([
                    'category',
                    'prices' => fn($q) => $q->where('is_available', true)->orderBy('price'),
                ]);
            }

            $allComponents = array_merge($loadedAnchor, $supportComponents);
            $allComponents = $this->resolveCompatibility($allComponents);

            $totalPrice = collect($allComponents)->sum('base_price');
            if ($totalPrice > $budget)
                continue;

            $bottleneckWarnings = $this->bottleneckAnalyzer->analyze($allComponents);
            $rawScore = $this->calculateOverallScore($allComponents, $useCase);
            $bottleneckCount = count($bottleneckWarnings);
            
            $penaltyPct = min($bottleneckCount * 8, 40);
            $performanceScore = max(0, $rawScore * (1 - $penaltyPct / 100));

            $evaluated[] = [
                'components' => $allComponents,
                'total_price' => $totalPrice,
                'performance_score' => $performanceScore,
                'raw_score' => $rawScore,
                'bottleneck_warnings' => $bottleneckWarnings,
                'bottleneck_count' => $bottleneckCount,
            ];
        }

        if (empty($evaluated))
            return null;

        $cleanBuilds = array_filter($evaluated, fn($b) => $b['bottleneck_count'] === 0);
        $warningBuilds = array_filter($evaluated, fn($b) => $b['bottleneck_count'] > 0);
        $pool = !empty($cleanBuilds) ? $cleanBuilds : $warningBuilds;

        if ($mode === 'max_budget') {
            // Max budget: prioritas score tinggi, bonus untuk habiskan budget
            // Formula: score + (score * budget_usage * 0.2)
            // Contoh: score 75, usage 95% → 75 + (75*0.95*0.2) = 89.25
            //         score 80, usage 70% → 80 + (80*0.70*0.2) = 91.2 (menang)
            usort($pool, function ($a, $b) use ($budget) {
                $usageA = $a['total_price'] / $budget;
                $usageB = $b['total_price'] / $budget;
                
                $valueA = $a['performance_score'] + ($a['performance_score'] * $usageA * 0.2);
                $valueB = $b['performance_score'] + ($b['performance_score'] * $usageB * 0.2);
                
                return $valueB <=> $valueA;
            });
        } else {
            // Balanced: maksimalkan score dengan pertimbangan efisiensi harga
            // Formula: score * (1 + efficiency_bonus)
            // Efficiency bonus: 0-20% tergantung seberapa hemat budget
            usort($pool, function ($a, $b) use ($budget) {
                $efficiencyA = 1 - ($a['total_price'] / $budget); // 0-1
                $efficiencyB = 1 - ($b['total_price'] / $budget);
                
                // Bonus maksimal 15% untuk build yang hemat
                $valueA = $a['performance_score'] * (1 + $efficiencyA * 0.15);
                $valueB = $b['performance_score'] * (1 + $efficiencyB * 0.15);
                
                return $valueB <=> $valueA;
            });
        }

        $best = array_values($pool)[0];

        return [
            'success' => true,
            'message' => $this->getBuildMessage($mode, (int)$best['performance_score'], $best['total_price'], $budget),
            'components' => $best['components'],
            'total_price' => $best['total_price'],
            'budget' => $budget,
            'budget_used_percent' => round(($best['total_price'] / $budget) * 100, 1),
            'use_case' => $useCase,
            'mode' => $mode,
            'bottleneck_warnings' => $best['bottleneck_warnings'],
            'performance_score' => (int)$best['performance_score'],
            'missing_categories' => [],
            'has_warning' => $best['bottleneck_count'] > 0,
        ];
    }

    // =========================================================================
    // COMPATIBILITY RESOLVER
    // =========================================================================

    protected function resolveCompatibility(array $components): array
    {
        $keys = array_keys($components);
        $componentList = array_values($components);

        for ($i = 0; $i < count($componentList); $i++) {
            for ($j = $i + 1; $j < count($componentList); $j++) {
                $a = $componentList[$i];
                $b = $componentList[$j];

                $rule = CompatibilityRule::where(
                    fn($q) => $q->where('component_a_id', $a->id)->where('component_b_id', $b->id)
                )->orWhere(
                        fn($q) => $q->where('component_a_id', $b->id)->where('component_b_id', $a->id)
                    )->first();

                if ($rule && $rule->status === 'incompatible') {
                    $categoryToSwap = $keys[$j];

                    $replacement = Component::whereHas('category', fn($q) => $q->where('slug', $categoryToSwap))
                        ->where('is_active', true)
                        ->where('base_price', '<=', $b->base_price * 1.3)
                        ->where('id', '!=', $b->id)
                        ->whereJsonContains('compatibility_tags', collect($a->compatibility_tags)->first())
                        ->orderByDesc('performance_score')
                        ->first();

                    if ($replacement) {
                        $components[$categoryToSwap] = $replacement->load([
                            'category',
                            'prices' => fn($q) => $q->where('is_available', true)->orderBy('price'),
                        ]);
                        $componentList[$j] = $components[$categoryToSwap];
                    }
                }
            }
        }

        return $components;
    }

    // =========================================================================
    // SCORING & HELPERS
    // =========================================================================

    protected function calculateOverallScore(array $components, string $useCase): int
    {
        if (empty($components))
            return 0;

        $weightMap = [
            'gaming' => ['gpu' => 0.40, 'cpu' => 0.25, 'ram' => 0.10, 'storage' => 0.08, 'motherboard' => 0.10, 'psu' => 0.04, 'cpu-cooler' => 0.02, 'case' => 0.01],
            'editing' => ['cpu' => 0.40, 'ram' => 0.20, 'gpu' => 0.15, 'storage' => 0.12, 'motherboard' => 0.08, 'psu' => 0.03, 'cpu-cooler' => 0.01, 'case' => 0.01],
            'work' => ['cpu' => 0.35, 'ram' => 0.20, 'storage' => 0.15, 'motherboard' => 0.15, 'gpu' => 0.08, 'psu' => 0.04, 'cpu-cooler' => 0.02, 'case' => 0.01],
            'study' => ['cpu' => 0.35, 'ram' => 0.20, 'storage' => 0.15, 'motherboard' => 0.15, 'gpu' => 0.08, 'psu' => 0.04, 'cpu-cooler' => 0.02, 'case' => 0.01],
        ];

        $weights = $weightMap[$useCase] ?? $weightMap['study'];
        $score = 0;
        $totalWeight = 0;

        foreach ($components as $slug => $component) {
            $weight = $weights[$slug] ?? 0.01;
            $score += ($component->performance_score ?? 0) * $weight;
            $totalWeight += $weight;
        }

        return $totalWeight > 0 ? (int) round($score / $totalWeight) : 0;
    }

    protected function buildFailResponse(
        int $budget,
        string $useCase,
        string $mode,
        array $missingCategories,
        array $partialComponents,
        string $reason
    ): array {
        $missingLabel = implode(', ', array_map('strtoupper', $missingCategories));

        $detail = match ($reason) {
            'support' => "Komponen pendukung ({$missingLabel}) tidak ditemukan dalam budget.",
            'no_anchor_budget' => "Budget habis untuk komponen pendukung — tidak cukup untuk CPU, GPU, dan Motherboard.",
            'anchor' => "Komponen utama ({$missingLabel}) tidak ditemukan dalam sisa budget.",
            default => "Beberapa komponen tidak ditemukan: {$missingLabel}.",
        };

        $minBudget = $this->estimateMinimumBudget(
            !in_array('gpu', $missingCategories),
            !in_array('psu', $missingCategories)
        );

        return [
            'success' => false,
            'message' => 'Belum ada build yang sesuai kebutuhanmu.',
            'detail' => $detail,
            'suggestion' => "Budget minimum yang disarankan adalah sekitar Rp " . number_format($minBudget, 0, ',', '.') . ".",
            'missing_categories' => $missingCategories,
            'components' => $partialComponents,
            'total_price' => 0,
            'budget' => $budget,
            'budget_used_percent' => 0,
            'use_case' => $useCase,
            'mode' => $mode,
            'bottleneck_warnings' => [],
            'performance_score' => 0,
            'has_warning' => false,
        ];
    }

    protected function estimateMinimumBudget(bool $includeGpu, bool $includePsu): int
    {
        $categories = self::REQUIRED_CATEGORIES;
        if (!$includeGpu)
            $categories = array_diff($categories, ['gpu']);
        if (!$includePsu)
            $categories = array_diff($categories, ['psu']);

        $totalMin = 0;
        foreach ($categories as $slug) {
            $cheapest = Component::whereHas('category', fn($q) => $q->where('slug', $slug))
                ->where('is_active', true)
                ->orderBy('base_price')
                ->value('base_price');
            $totalMin += $cheapest ?? 0;
        }

        return (int) ($totalMin * 1.20);
    }

    protected function getBuildMessage(string $mode, int $score, float $totalPrice, int $budget): string
    {
        $usedPercent = round(($totalPrice / $budget) * 100);

        if ($mode === 'max_budget') {
            return "Build performa maksimal — menggunakan {$usedPercent}% budget dengan score {$score}/100.";
        }

        if ($score >= 80)
            return "Build sangat worth it — performa tinggi dengan budget efisien ({$usedPercent}% terpakai).";
        if ($score >= 60)
            return "Build solid — performa baik untuk harganya ({$usedPercent}% budget terpakai).";
        return "Build ditemukan — pertimbangkan naikkan budget untuk performa lebih baik ({$usedPercent}% terpakai).";
    }
}