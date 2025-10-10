<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Person;
use App\Models\Company;
use App\Observers\PersonObserver;
use App\Observers\CompanyObserver;

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
        
        // Registrar el observer para el modelo Company
        Company::observe(CompanyObserver::class);
    }
}
