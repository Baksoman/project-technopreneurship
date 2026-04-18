<?php

namespace App\Livewire\User;

use Livewire\Component;

class OnboardingModal extends Component
{
    public bool $show = false;
    public int $currentSlide = 0;

    public function mount()
    {
        if (!session()->has('user_id') && !session()->has('onboarding_seen')) {
            $this->show = true;
        }
    }

    public function nextSlide()
    {
        if ($this->currentSlide < 3) {
            $this->currentSlide++;
        }
    }

    public function prevSlide()
    {
        if ($this->currentSlide > 0) {
            $this->currentSlide--;
        }
    }

    public function close()
    {
        session()->put('onboarding_seen', true);
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.user.onboarding-modal');
    }
}
