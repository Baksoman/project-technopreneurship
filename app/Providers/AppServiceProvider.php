<?php

namespace App\Providers;

use App;
use App\Models\Component;
use App\Models\ComponentCategory;
use App\Observers\ComponentObserver;
use App\Observers\ComponentCategoryObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Component::observe(ComponentObserver::class);
        ComponentCategory::observe(ComponentCategoryObserver::class);

        if (App::environment('production')) {
            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/livewire/update', $handle);
            });
        }
    }
}
