<?php

namespace App\Livewire;

use App\Models\Component;
use App\Models\ComponentCategory;
use App\Models\CompatibilityRule;
use App\Models\Build;
use Illuminate\Support\Facades\Auth;
use Livewire\Component as LivewireComponent;

class CompatibilityChecker extends LivewireComponent
{
    public array $selectedComponents = [];
    public array $results = [];
    public bool $hasChecked = false;
    public string $inputMode = 'manual'; // 'manual' or 'saved'
    public ?string $selectedBuildId = null;

    public function mount(?string $buildId = null): void
    {
        $categories = ComponentCategory::all();
        foreach ($categories as $cat) {
            $this->selectedComponents[$cat->slug] = '';
        }

        if ($buildId) {
            $this->loadBuildComponents($buildId);
        }
    }

    public function loadBuildComponents(string $buildId): void
    {
        $build = Build::with('components.category')->find($buildId);
        if (!$build) return;

        foreach ($build->components as $component) {
            $this->selectedComponents[$component->category->slug] = $component->id;
        }
        $this->inputMode = 'manual';
    }

    public function loadSavedBuild(): void
    {
        if (!$this->selectedBuildId) return;
        $this->loadBuildComponents($this->selectedBuildId);
    }

    public function check(): void
    {
        $this->hasChecked = false;
        $this->results = [];

        // Validasi komponen wajib
        $required = ['cpu', 'motherboard', 'storage', 'ram', 'case', 'cpu-cooler', 'psu'];
        $missing = [];

        foreach ($required as $slug) {
            if (empty($this->selectedComponents[$slug])) {
                $missing[] = strtoupper($slug);
            }
        }

        if (!empty($missing)) {
            session()->flash('error', 'Komponen wajib belum dipilih: ' . implode(', ', $missing));
            return;
        }

        $selected = collect($this->selectedComponents)
            ->filter(fn($id) => !empty($id))
            ->map(fn($id) => Component::find($id))
            ->filter()
            ->values();

        if ($selected->count() < 2) {
            session()->flash('error', 'Pilih minimal 2 komponen untuk dicek.');
            return;
        }

        for ($i = 0; $i < $selected->count(); $i++) {
            for ($j = $i + 1; $j < $selected->count(); $j++) {
                $a = $selected[$i];
                $b = $selected[$j];

                $rule = CompatibilityRule::where(function ($q) use ($a, $b) {
                    $q->where('component_a_id', $a->id)->where('component_b_id', $b->id);
                })->orWhere(function ($q) use ($a, $b) {
                    $q->where('component_a_id', $b->id)->where('component_b_id', $a->id);
                })->first();

                $this->results[] = [
                    'component_a' => $a->name,
                    'component_b' => $b->name,
                    'status' => $rule?->status ?? 'compatible',
                    'message' => $rule?->message ?? 'Tidak ada konflik yang diketahui',
                    'suggestion' => $rule?->suggestion,
                ];
            }
        }

        $this->hasChecked = true;
    }

    public function render()
    {
        $categories = ComponentCategory::with(['components' => fn($q) => $q->where('is_active', true)->orderBy('name')])->get();
        $savedBuilds = session()->has('user_id') ? Build::where('user_id', session('user_id'))->latest()->get() : collect();
        return view('livewire.compatibility-checker', compact('categories', 'savedBuilds'));
    }
}