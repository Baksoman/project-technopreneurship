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
        'storage' => 55,
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

        // Support boleh pakai maksimal 30% budget
        $supportBudgetCap = $totalBudget * 0.30;

        foreach ($categories as $slug) {
            $minScore = self::SUPPORT_MIN_SCORE[$slug] ?? 50;
            $candidate = $this->pickSupportCandidate($slug, $minScore, $mode);

            if (!$candidate) {
                // Coba tanpa minimum score
                $candidate = $this->pickCheapestSupport($slug);
            }

            if (!$candidate) {
                $failed[] = $slug;
                continue;
            }

            // Jika melebihi cap, cari yang lebih murah
            if (($totalCost + $candidate->base_price) > $supportBudgetCap) {
                $cheaper = $this->pickCheapestSupport($slug);
                if ($cheaper && ($totalCost + $cheaper->base_price) <= $supportBudgetCap) {
                    $candidate = $cheaper;
                }
                // Kalau tetap melebihi cap, tetap pakai — lebih baik build ada
            }

            // Hard limit: satu komponen tidak boleh melebihi total budget
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

        // Untuk support components, selalu pilih yang paling worth it
        // Biar budget bisa dimaksimalkan di anchor components (CPU, GPU, Motherboard)
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

        // Filter & normalisasi alokasi sesuai kategori aktif
        $activeAlloc = array_filter($allocation, fn($slug) => in_array($slug, $anchorCategories), ARRAY_FILTER_USE_KEY);
        $totalPct = array_sum($activeAlloc);
        $normalized = array_map(fn($pct) => ($pct / $totalPct) * 100, $activeAlloc);

        // Ambil top-N kandidat per kategori
        $candidatesPerSlug = [];
        foreach ($normalized as $slug => $percentage) {
            $slugBudget = ($percentage / 100) * $anchorBudget;

            // Ambil beberapa kandidat terbaik dalam budget (strict — tidak boleh over)
            $candidatesPerSlug[$slug] = $this->getAnchorCandidatesStrict(
                slug: $slug,
                budget: $slugBudget,
                brandPreference: $brandPreference,
                mode: $mode,
                limit: self::CANDIDATE_BUILDS,
            );

            if ($candidatesPerSlug[$slug]->isEmpty()) {
                // Tidak ada kandidat sama sekali → gagal
                return [];
            }
        }

        // Buat kombinasi build dari kandidat-kandidat tersebut
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
            ->where('base_price', '<=', $budget); // strict — tidak ada toleransi over budget

        if ($brandPreference !== 'any' && in_array($slug, ['cpu', 'gpu'])) {
            $brandQuery = clone $query;
            $brandQuery->where('brand', $brandPreference);

            // Fallback ke semua brand jika preferensi brand tidak ada kandidat
            if ($brandQuery->count() > 0) {
                $query = $brandQuery;
            }
        }

        if ($mode === 'max_budget') {
            // Max budget: ambil yang harganya paling tinggi (dalam budget) dengan score bagus
            // Prioritas: habiskan budget sebanyak mungkin
            return $query->orderByDesc('base_price')
                ->orderByDesc('performance_score')
                ->limit($limit)
                ->get();
        }

        // Balanced: ambil berdasarkan campuran score & price efficiency
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

        for ($i = 0; $i < min($maxLen, self::CANDIDATE_BUILDS); $i++) {
            $build = [];
            $buildCost = 0;
            $valid = true;

            foreach ($slugs as $slug) {
                $candidates = $candidatesPerSlug[$slug];

                // Pilih kandidat ke-i, atau kandidat terakhir jika tidak ada
                $component = $candidates->get($i) ?? $candidates->last();

                if (!$component) {
                    $valid = false;
                    break;
                }

                // Pastikan total anchor build tidak melebihi anchor budget
                if (($buildCost + $component->base_price) > $anchorBudget) {
                    // Coba pakai yang lebih murah (kandidat pertama = paling worth it)
                    $component = $candidates->first();
                    if (!$component || ($buildCost + $component->base_price) > $anchorBudget) {
                        $valid = false;
                        break;
                    }
                }

                $build[$slug] = $component;
                $buildCost += $component->base_price;
            }

            if ($valid && !empty($build)) {
                $builds[] = $build;
            }
        }

        return $builds;
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
            // Load relasi
            $loadedAnchor = [];
            foreach ($anchorBuild as $slug => $component) {
                $loadedAnchor[$slug] = $component->load([
                    'category',
                    'prices' => fn($q) => $q->where('is_available', true)->orderBy('price'),
                ]);
            }

            // Gabungkan dengan support
            $allComponents = array_merge($loadedAnchor, $supportComponents);

            // Resolve kompatibilitas
            $allComponents = $this->resolveCompatibility($allComponents);

            // Cek total harga — tidak boleh melebihi budget
            $totalPrice = collect($allComponents)->sum('base_price');
            if ($totalPrice > $budget)
                continue;

            // Analisa bottleneck
            $bottleneckWarnings = $this->bottleneckAnalyzer->analyze($allComponents);
            $penalty = $this->bottleneckAnalyzer->calculatePenalty($bottleneckWarnings);

            $performanceScore = max(0, $this->calculateOverallScore($allComponents, $useCase) - $penalty);
            $bottleneckCount = count($bottleneckWarnings);

            $evaluated[] = [
                'components' => $allComponents,
                'total_price' => $totalPrice,
                'performance_score' => $performanceScore,
                'bottleneck_warnings' => $bottleneckWarnings,
                'bottleneck_count' => $bottleneckCount,
                'penalty' => $penalty,
            ];
        }

        if (empty($evaluated))
            return null;

        // Prioritas pemilihan:
        // 1. Build tanpa bottleneck/warning diutamakan
        // 2. Dalam grup yang sama, pilih berdasarkan mode:
        //    - balanced    → score tertinggi (sudah dikurangi penalty)
        //    - max_budget  → score tertinggi (sudah dikurangi penalty)
        //    Bedanya: max_budget juga mempertimbangkan total_price (habiskan budget)

        // Pisahkan build tanpa warning dan yang ada warning
        $cleanBuilds = array_filter($evaluated, fn($b) => $b['bottleneck_count'] === 0);
        $warningBuilds = array_filter($evaluated, fn($b) => $b['bottleneck_count'] > 0);

        // Pilih dari build bersih dulu
        $pool = !empty($cleanBuilds) ? $cleanBuilds : $warningBuilds;

        if ($mode === 'max_budget') {
            // Max budget: score tertinggi, jika sama pilih yang harganya lebih tinggi (habiskan budget)
            usort($pool, function ($a, $b) {
                if ($a['performance_score'] !== $b['performance_score']) {
                    return $b['performance_score'] - $a['performance_score'];
                }
                return $b['total_price'] - $a['total_price']; // habiskan budget
            });
        } else {
            // Balanced: score tertinggi (score sudah memperhitungkan price efficiency)
            usort($pool, fn($a, $b) => $b['performance_score'] - $a['performance_score']);
        }

        $best = array_values($pool)[0];

        $totalPrice = $best['total_price'];

        return [
            'success' => true,
            'message' => $this->getBuildMessage($mode, $best['performance_score'], $totalPrice, $budget),
            'components' => $best['components'],
            'total_price' => $totalPrice,
            'budget' => $budget,
            'budget_used_percent' => round(($totalPrice / $budget) * 100, 1),
            'use_case' => $useCase,
            'mode' => $mode,
            'bottleneck_warnings' => $best['bottleneck_warnings'],
            'performance_score' => $best['performance_score'],
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