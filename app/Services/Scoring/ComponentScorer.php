<?php

namespace App\Services\Scoring;

use App\Models\Component;

class ComponentScorer
{
    public function score(Component $component, float $categoryBudget, array $weights): float
    {
        return round(
            ($this->scorePerformance($component) * $weights['performance']) +
            ($this->scorePriceEfficiency($component, $categoryBudget) * $weights['price_efficiency']) +
            ($this->scoreTdpEfficiency($component) * $weights['tdp_efficiency']),
            4
        );
    }

    protected function scorePerformance(Component $component): float
    {
        return ($component->performance_score ?? 0) / 100;
    }

    protected function scorePriceEfficiency(Component $component, float $budget): float
    {
        if ($component->base_price <= 0)
            return 0;
        $efficiency = ($component->performance_score ?? 0) / ($component->base_price / 1_000_000);
        return min($efficiency / 50, 1.0);
    }

    protected function scoreTdpEfficiency(Component $component): float
    {
        if (!$component->tdp)
            return 0.5;
        return match (true) {
            $component->tdp <= 35 => 1.00,
            $component->tdp <= 65 => 0.85,
            $component->tdp <= 105 => 0.70,
            $component->tdp <= 150 => 0.55,
            $component->tdp <= 200 => 0.40,
            $component->tdp <= 250 => 0.25,
            default => 0.10,
        };
    }
}
