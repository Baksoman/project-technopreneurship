<?php

namespace App\Livewire\User;

use App\Services\BuildRecommenderService;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;
use App\Models\Build;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BuildComparison extends Component
{
    public string $modeA = 'new'; // 'new' or 'saved'
    public string $modeB = 'new';
    public ?string $savedBuildIdA = null;
    public ?string $savedBuildIdB = null;

    // Build A (new)
    public int $budgetA = 0;
    public string $useCaseA = 'gaming';
    public string $brandPreferenceA = 'any';
    public string $modeA_build = 'balanced'; // 'balanced' | 'max_budget'
    public bool $includeGpuA = true;
    public bool $includePsuA = true;

    // Build B (new)
    public int $budgetB = 0;
    public string $useCaseB = 'gaming';
    public string $brandPreferenceB = 'any';
    public string $modeB_build = 'balanced'; // 'balanced' | 'max_budget'
    public bool $includeGpuB = true;
    public bool $includePsuB = true;

    public bool $hasResult = false;
    public array $buildA = [];
    public array $buildB = [];

    public function mount(?string $buildIdA = null): void
    {
        if ($buildIdA) {
            $this->modeA = 'saved';
            $this->savedBuildIdA = $buildIdA;
        }
    }

    public function compare(): void
    {
        $this->hasResult = false;

        // Load Build A
        if ($this->modeA === 'saved' && $this->savedBuildIdA) {
            $this->buildA = $this->loadSavedBuild($this->savedBuildIdA);
        } else {
            $this->validate([
                'budgetA' => 'required|integer|min:1500000',
                'useCaseA' => 'required|in:gaming,work,editing,study',
                'brandPreferenceA' => 'required|in:any,AMD,Intel,NVIDIA',
            ]);
            $service = new BuildRecommenderService(new ComponentScorer(), new BottleneckAnalyzer());
            $this->buildA = $service->recommend($this->budgetA, $this->useCaseA, $this->brandPreferenceA, $this->includeGpuA, $this->includePsuA, $this->modeA_build);
        }

        // Load Build B
        if ($this->modeB === 'saved' && $this->savedBuildIdB) {
            $this->buildB = $this->loadSavedBuild($this->savedBuildIdB);
        } else {
            $this->validate([
                'budgetB' => 'required|integer|min:1500000',
                'useCaseB' => 'required|in:gaming,work,editing,study',
                'brandPreferenceB' => 'required|in:any,AMD,Intel,NVIDIA',
            ]);
            $service = new BuildRecommenderService(new ComponentScorer(), new BottleneckAnalyzer());
            $this->buildB = $service->recommend($this->budgetB, $this->useCaseB, $this->brandPreferenceB, $this->includeGpuB, $this->includePsuB, $this->modeB_build);
        }

        $this->hasResult = true;
    }

    protected function loadSavedBuild(string $buildId): array
    {
        $build = Build::with('components.category')->find($buildId);
        if (!$build) return [];

        $components = [];
        foreach ($build->components as $component) {
            $components[$component->category->slug] = $component;
        }

        return [
            'components' => $components,
            'total_price' => $build->total_price,
            'budget' => $build->budget,
            'use_case' => $build->use_case,
            'performance_score' => $build->performance_score,
            'bottleneck_warnings' => $build->bottleneck_details ?? [],
        ];
    }

    public function render()
    {
        $savedBuilds = session()->has('user_id') ? Build::where('user_id', session('user_id'))->latest()->get() : collect();
        return view('livewire.user.build-comparison', compact('savedBuilds'));
    }
}