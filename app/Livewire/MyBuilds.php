<?php

namespace App\Livewire;

use App\Models\Build;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyBuilds extends Component
{
    public function deleteBuild(string $buildId): void
    {
        $build = Build::where('id', $buildId)->where('user_id', session('user_id'))->first();
        
        if ($build) {
            $build->delete();
            session()->flash('success', 'Build berhasil dihapus!');
        }
    }

    public function render()
    {
        $builds = Build::where('user_id', session('user_id'))
            ->with('components.category')
            ->latest()
            ->get();

        return view('livewire.my-builds', compact('builds'));
    }
}
