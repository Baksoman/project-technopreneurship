<?php

namespace App\Livewire\User;

use App\Services\BuildRecommenderService;
use App\Services\Scoring\ComponentScorer;
use App\Services\Scoring\BottleneckAnalyzer;
use App\Models\Build;
use Livewire\Component;

class BuildRecommender extends Component
{
    public int $budget = 0;
    public string $useCase = 'gaming';
    public string $brandPreference = 'any';
    public string $mode = 'balanced'; // 'balanced' | 'max_budget'
    public bool $includeGpu = true;
    public bool $includePsu = true;
    public bool $isLoading = false;
    public bool $hasResult = false;
    public array $result = [];
    public ?string $savedBuildId = null;
    public bool $isAuthenticated = false;

    protected array $rules = [
        'budget' => 'required|integer|min:1500000|max:100000000',
        'useCase' => 'required|in:gaming,work,editing,study',
        'brandPreference' => 'required|in:any,AMD,Intel,NVIDIA',
        'mode' => 'required|in:balanced,max_budget',
    ];

    protected array $messages = [
        'budget.min' => 'Budget minimal Rp 1.500.000.',
        'budget.max' => 'Budget maksimal Rp 100.000.000.',
    ];

    public function mount(): void
    {
        $this->isAuthenticated = session()->has('user_id');
    }

    public function hydrate(): void
    {
        $this->isAuthenticated = session()->has('user_id');
    }

    public function recommend(): void
    {
        $this->validate();
        $this->isLoading = true;
        $this->hasResult = false;
        $this->savedBuildId = null;

        try {
            $service = new BuildRecommenderService(new ComponentScorer(), new BottleneckAnalyzer());
            $this->result = $service->recommend(
                budget: $this->budget,
                useCase: $this->useCase,
                brandPreference: $this->brandPreference,
                includeGpu: $this->includeGpu,
                includePsu: $this->includePsu,
                mode: $this->mode,
            );
            $this->hasResult = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function saveBuild(): void
    {
        if (!session()->has('user_id')) {
            session()->flash('error', 'Login dulu untuk simpan build.');
            $this->redirect(route('login'));
            return;
        }

        if (!$this->hasResult || !($this->result['success'] ?? false)) {
            session()->flash('error', 'Belum ada build valid untuk disimpan.');
            return;
        }

        $build = Build::create([
            'user_id' => session('user_id'),
            'name' => ucfirst($this->useCase) . ' Build - Rp ' . number_format($this->budget / 1000000, 1) . 'jt',
            'use_case' => $this->useCase,
            'budget' => $this->budget,
            'total_price' => $this->result['total_price'],
            'performance_score' => $this->result['performance_score'],
            'has_bottleneck' => !empty($this->result['bottleneck_warnings']),
            'bottleneck_details' => $this->result['bottleneck_warnings'],
            'status' => 'draft',
            'is_public' => false,
        ]);

        foreach ($this->result['components'] as $component) {
            $build->components()->attach($component->id, [
                'quantity' => 1,
                'price_at_time' => $component->base_price,
            ]);
        }

        $this->savedBuildId = $build->id;
        session()->flash('success', 'Build berhasil disimpan!');
    }

    public function resetForm(): void
    {
        $this->reset(['result', 'hasResult', 'savedBuildId']);
    }

    public function render()
    {
        return view('livewire.user.build-recommender');
    }
}