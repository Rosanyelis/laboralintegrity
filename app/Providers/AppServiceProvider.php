<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Person;
use App\Models\Company;
use App\Models\Recruiter;
use App\Observers\PersonObserver;
use App\Observers\CompanyObserver;
use App\Observers\RecruiterObserver;

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
        
        // Registrar el observer para el modelo Recruiter
        Recruiter::observe(RecruiterObserver::class);
    }
}
