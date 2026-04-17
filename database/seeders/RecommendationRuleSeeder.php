<?php

namespace Database\Seeders;

use App\Models\RecommendationRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecommendationRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            // GAMING
            ['use_case' => 'gaming', 'category_slug' => 'gpu', 'budget_percentage' => 38, 'priority' => 1, 'scoring_weights' => ['performance' => 0.60, 'price_efficiency' => 0.25, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'gaming', 'category_slug' => 'cpu', 'budget_percentage' => 22, 'priority' => 2, 'scoring_weights' => ['performance' => 0.50, 'price_efficiency' => 0.30, 'tdp_efficiency' => 0.20]],
            ['use_case' => 'gaming', 'category_slug' => 'ram', 'budget_percentage' => 10, 'priority' => 3, 'scoring_weights' => ['performance' => 0.40, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'gaming', 'category_slug' => 'storage', 'budget_percentage' => 8, 'priority' => 4, 'scoring_weights' => ['performance' => 0.30, 'price_efficiency' => 0.60, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'gaming', 'category_slug' => 'motherboard', 'budget_percentage' => 12, 'priority' => 5, 'scoring_weights' => ['performance' => 0.35, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'gaming', 'category_slug' => 'psu', 'budget_percentage' => 7, 'priority' => 6, 'scoring_weights' => ['performance' => 0.20, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.30]],
            ['use_case' => 'gaming', 'category_slug' => 'case', 'budget_percentage' => 3, 'priority' => 7, 'scoring_weights' => ['performance' => 0.10, 'price_efficiency' => 0.70, 'tdp_efficiency' => 0.20]],
            // EDITING
            ['use_case' => 'editing', 'category_slug' => 'cpu', 'budget_percentage' => 35, 'priority' => 1, 'scoring_weights' => ['performance' => 0.65, 'price_efficiency' => 0.20, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'editing', 'category_slug' => 'ram', 'budget_percentage' => 18, 'priority' => 2, 'scoring_weights' => ['performance' => 0.55, 'price_efficiency' => 0.35, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'editing', 'category_slug' => 'gpu', 'budget_percentage' => 20, 'priority' => 3, 'scoring_weights' => ['performance' => 0.50, 'price_efficiency' => 0.35, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'editing', 'category_slug' => 'storage', 'budget_percentage' => 14, 'priority' => 4, 'scoring_weights' => ['performance' => 0.45, 'price_efficiency' => 0.45, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'editing', 'category_slug' => 'motherboard', 'budget_percentage' => 8, 'priority' => 5, 'scoring_weights' => ['performance' => 0.30, 'price_efficiency' => 0.55, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'editing', 'category_slug' => 'psu', 'budget_percentage' => 4, 'priority' => 6, 'scoring_weights' => ['performance' => 0.20, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.30]],
            ['use_case' => 'editing', 'category_slug' => 'case', 'budget_percentage' => 1, 'priority' => 7, 'scoring_weights' => ['performance' => 0.10, 'price_efficiency' => 0.70, 'tdp_efficiency' => 0.20]],
            // WORK
            ['use_case' => 'work', 'category_slug' => 'cpu', 'budget_percentage' => 30, 'priority' => 1, 'scoring_weights' => ['performance' => 0.50, 'price_efficiency' => 0.35, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'work', 'category_slug' => 'ram', 'budget_percentage' => 20, 'priority' => 2, 'scoring_weights' => ['performance' => 0.45, 'price_efficiency' => 0.45, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'work', 'category_slug' => 'storage', 'budget_percentage' => 18, 'priority' => 3, 'scoring_weights' => ['performance' => 0.40, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'work', 'category_slug' => 'motherboard', 'budget_percentage' => 15, 'priority' => 4, 'scoring_weights' => ['performance' => 0.30, 'price_efficiency' => 0.55, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'work', 'category_slug' => 'gpu', 'budget_percentage' => 10, 'priority' => 5, 'scoring_weights' => ['performance' => 0.35, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.15]],
            ['use_case' => 'work', 'category_slug' => 'psu', 'budget_percentage' => 5, 'priority' => 6, 'scoring_weights' => ['performance' => 0.20, 'price_efficiency' => 0.50, 'tdp_efficiency' => 0.30]],
            ['use_case' => 'work', 'category_slug' => 'case', 'budget_percentage' => 2, 'priority' => 7, 'scoring_weights' => ['performance' => 0.10, 'price_efficiency' => 0.70, 'tdp_efficiency' => 0.20]],
            // STUDY
            ['use_case' => 'study', 'category_slug' => 'cpu', 'budget_percentage' => 28, 'priority' => 1, 'scoring_weights' => ['performance' => 0.35, 'price_efficiency' => 0.55, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'study', 'category_slug' => 'ram', 'budget_percentage' => 20, 'priority' => 2, 'scoring_weights' => ['performance' => 0.30, 'price_efficiency' => 0.60, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'study', 'category_slug' => 'storage', 'budget_percentage' => 18, 'priority' => 3, 'scoring_weights' => ['performance' => 0.25, 'price_efficiency' => 0.65, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'study', 'category_slug' => 'motherboard', 'budget_percentage' => 15, 'priority' => 4, 'scoring_weights' => ['performance' => 0.25, 'price_efficiency' => 0.65, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'study', 'category_slug' => 'gpu', 'budget_percentage' => 12, 'priority' => 5, 'scoring_weights' => ['performance' => 0.30, 'price_efficiency' => 0.60, 'tdp_efficiency' => 0.10]],
            ['use_case' => 'study', 'category_slug' => 'psu', 'budget_percentage' => 5, 'priority' => 6, 'scoring_weights' => ['performance' => 0.15, 'price_efficiency' => 0.65, 'tdp_efficiency' => 0.20]],
            ['use_case' => 'study', 'category_slug' => 'case', 'budget_percentage' => 2, 'priority' => 7, 'scoring_weights' => ['performance' => 0.10, 'price_efficiency' => 0.70, 'tdp_efficiency' => 0.20]],
        ];

        foreach ($rules as $rule) {
            RecommendationRule::create(['id' => Str::uuid(), ...$rule]);
        }
    }
}
