<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Person;
use App\Observers\PersonObserver;

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
        // Registrar el observer para el modelo Person
        Person::observe(PersonObserver::class);
    }
}
