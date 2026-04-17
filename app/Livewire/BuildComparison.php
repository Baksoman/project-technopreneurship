<?php

namespace App\Livewire;

use App\Services\BuildRecommenderService;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;
use Livewire\Component;

class BuildComparison extends Component
{
    // Build A
    public int $budgetA = 5000000;
    public string $useCaseA = 'gaming';
    public string $brandPreferenceA = 'any';

    // Build B
    public int $budgetB = 8000000;
    public string $useCaseB = 'gaming';
    public string $brandPreferenceB = 'any';

    public bool $hasResult = false;
    public array $buildA = [];
    public array $buildB = [];

    public function compare(): void
    {
        $this->validate([
            'budgetA' => 'required|integer|min:1500000',
            'useCaseA' => 'required|in:gaming,work,editing,study',
            'brandPreferenceA' => 'required|in:any,AMD,Intel,NVIDIA',
            'budgetB' => 'required|integer|min:1500000',
            'useCaseB' => 'required|in:gaming,work,editing,study',
            'brandPreferenceB' => 'required|in:any,AMD,Intel,NVIDIA',
        ]);

        $service = new BuildRecommenderService(new ComponentScorer(), new BottleneckAnalyzer());
        $this->buildA = $service->recommend($this->budgetA, $this->useCaseA, $this->brandPreferenceA);
        $this->buildB = $service->recommend($this->budgetB, $this->useCaseB, $this->brandPreferenceB);
        $this->hasResult = true;
    }

    public function render()
    {
        return view('livewire.build-comparison');
    }
}