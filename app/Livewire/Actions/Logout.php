<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Session;

class Logout
{
    public function __invoke(): void
    {
        Session::flush();
        Session::regenerate();
    }
}
