<?php

namespace App\Services;

use App\Models\Component;
use App\Models\CompatibilityRule;
use App\Models\RecommendationRule;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;

class BuildRecommenderService
{
    public function __construct(
        protected ComponentScorer $scorer,
        protected BottleneckAnalyzer $bottleneckAnalyzer,
    ) {
    }

    public function recommend(int $budget, string $useCase, string $brandPreference = 'any', bool $includePsu = true): array
    {
        $rules = RecommendationRule::where('use_case', $useCase)->orderBy('priority')->get();
        $selectedComponents = [];

        foreach ($rules as $rule) {
            if (!$includePsu && $rule->category_slug === 'psu')
                continue;

            $categoryBudget = ($rule->budget_percentage / 100) * $budget;
            $candidates = $this->getCandidates($rule->category_slug, $categoryBudget, $brandPreference);
            if ($candidates->isEmpty())
                continue;

            $best = $candidates->map(fn($c) => [
                'component' => $c,
                'score' => $this->scorer->score($c, $categoryBudget, $rule->scoring_weights),
            ])->sortByDesc('score')->first();

            if ($best) {
                $selectedComponents[$rule->category_slug] = $best['component']->load([
                    'category',
                    'prices' => fn($q) => $q->where('is_available', true)->orderBy('price'),
                ]);
            }
        }

        $selectedComponents = $this->resolveCompatibility($selectedComponents);
        $bottleneckWarnings = $this->bottleneckAnalyzer->analyze($selectedComponents);
        $penalty = $this->bottleneckAnalyzer->calculatePenalty($bottleneckWarnings);

        return [
            'components' => $selectedComponents,
            'total_price' => collect($selectedComponents)->sum('base_price'),
            'budget' => $budget,
            'use_case' => $useCase,
            'bottleneck_warnings' => $bottleneckWarnings,
            'performance_score' => max(0, $this->calculateOverallScore($selectedComponents, $useCase) - $penalty),
        ];
    }

    protected function getCandidates(string $categorySlug, float $budget, string $brandPreference)
    {
        $query = Component::whereHas('category', fn($q) => $q->where('slug', $categorySlug))
            ->where('is_active', true)
            ->where('base_price', '<=', $budget * 1.15);

        if ($brandPreference !== 'any' && in_array($categorySlug, ['cpu', 'gpu'])) {
            $query->where('brand', $brandPreference);
        }

        return $query->get();
    }

    protected function resolveCompatibility(array $components): array
    {
        $keys = array_keys($components);
        $componentList = array_values($components);

        for ($i = 0; $i < count($componentList); $i++) {
            for ($j = $i + 1; $j < count($componentList); $j++) {
                $a = $componentList[$i];
                $b = $componentList[$j];

                $rule = CompatibilityRule::where(fn($q) => $q->where('component_a_id', $a->id)->where('component_b_id', $b->id))
                    ->orWhere(fn($q) => $q->where('component_a_id', $b->id)->where('component_b_id', $a->id))
                    ->first();

                if ($rule && $rule->status === 'incompatible') {
                    $categoryToSwap = $keys[$j];
                    $replacement = Component::whereHas('category', fn($q) => $q->where('slug', $categoryToSwap))
                        ->where('is_active', true)
                        ->where('base_price', '<=', $b->base_price * 1.2)
                        ->where('id', '!=', $b->id)
                        ->whereJsonContains('compatibility_tags', collect($a->compatibility_tags)->first())
                        ->orderByDesc('performance_score')
                        ->first();

                    if ($replacement) {
                        $components[$categoryToSwap] = $replacement->load(['category', 'prices' => fn($q) => $q->where('is_available', true)->orderBy('price')]);
                        $componentList[$j] = $components[$categoryToSwap];
                    }
                }
            }
        }

        return $components;
    }

    protected function calculateOverallScore(array $components, string $useCase): int
    {
        if (empty($components))
            return 0;
        $rules = RecommendationRule::where('use_case', $useCase)->get()->keyBy('category_slug');
        $score = 0;
        $totalWeight = 0;
        foreach ($components as $slug => $component) {
            $weight = $rules->get($slug)?->budget_percentage / 100 ?? 0.1;
            $score += ($component->performance_score ?? 0) * $weight;
            $totalWeight += $weight;
        }
        return $totalWeight > 0 ? (int) round($score / $totalWeight) : 0;
    }
}
