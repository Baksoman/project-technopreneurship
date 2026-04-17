<?php

namespace App\Livewire;

use App\Services\BuildRecommenderService;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;
use Livewire\Component;

class BuildRecommender extends Component
{
    public int $budget = 5000000;
    public string $useCase = 'gaming';
    public string $brandPreference = 'any';
    public bool $includeGpu = true;
    public bool $includePsu = true;
    public bool $isLoading = false;
    public bool $hasResult = false;
    public array $result = [];

    protected array $rules = [
        'budget' => 'required|integer|min:1500000|max:100000000',
        'useCase' => 'required|in:gaming,work,editing,study',
        'brandPreference' => 'required|in:any,AMD,Intel,NVIDIA',
    ];

    protected array $messages = [
        'budget.min' => 'Budget minimal Rp 1.500.000.',
        'budget.max' => 'Budget maksimal Rp 100.000.000.',
    ];

    public function recommend(): void
    {
        $this->validate();
        $this->isLoading = true;
        $this->hasResult = false;

        try {
            $service = new BuildRecommenderService(new ComponentScorer(), new BottleneckAnalyzer());
            $this->result = $service->recommend(
                budget: $this->budget,
                useCase: $this->useCase,
                brandPreference: $this->brandPreference,
                includeGpu: $this->includeGpu,
                includePsu: $this->includePsu,
            );
            $this->hasResult = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function resetForm(): void
    {
        $this->reset(['result', 'hasResult']);
    }

    public function render()
    {
        return view('livewire.build-recommender');
    }
}