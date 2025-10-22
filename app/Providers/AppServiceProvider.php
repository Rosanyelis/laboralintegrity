<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Person;
use App\Models\Company;
use App\Models\Recruiter;
use App\Models\WorkIntegrity;
use App\Models\Certification;
use App\Models\ReferenceCode;
use App\Models\Role;
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

        // Definir Gates personalizados para módulos críticos
        $this->defineSecurityGates();
    }

    /**
     * Definir Gates de seguridad para módulos críticos
     */
    private function defineSecurityGates(): void
    {
        // Gate para acceso administrativo
        Gate::define('admin-access', function ($user) {
            return $user->hasRole(['Super Administrador', 'Administrador']);
        });

        // Gate para acceso a resultados reales de depuraciones
        Gate::define('view-actual-results', function ($user) {
            return $user->can('work-integrities.view-actual-results');
        });

        // Gate para gestión de roles
        Gate::define('manage-roles', function ($user) {
            return $user->hasRole('Super Administrador') || $user->can('roles.create');
        });

        // Gate para eliminación de registros críticos
        Gate::define('delete-critical-records', function ($user) {
            return $user->hasRole('Super Administrador');
        });

        // Gate para exportación de datos
        Gate::define('export-data', function ($user) {
            return $user->hasRole(['Super Administrador', 'Administrador']);
        });

        // Gate para acceso a estadísticas
        Gate::define('view-statistics', function ($user) {
            return $user->hasRole(['Super Administrador', 'Administrador']);
        });

        // Gate para gestión de usuarios
        Gate::define('manage-users', function ($user) {
            return $user->hasRole('Super Administrador');
        });

        // Gate para acceso a configuración del sistema
        Gate::define('system-config', function ($user) {
            return $user->hasRole('Super Administrador');
        });

        // Hook before para Super Administradores
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Administrador')) {
                return true;
            }
        });

        // Hook after para verificar permisos específicos
        Gate::after(function ($user, $ability, $result, $arguments) {
            // Si el resultado es null, verificar permisos específicos
            if ($result === null) {
                switch ($ability) {
                    case 'view-actual-results':
                        return $user->can('work-integrities.view-actual-results');
                    case 'manage-roles':
                        return $user->hasRole('Super Administrador') || $user->can('roles.create');
                    case 'delete-critical-records':
                        return $user->hasRole('Super Administrador');
                    case 'export-data':
                        return $user->hasRole(['Super Administrador', 'Administrador']);
                    case 'view-statistics':
                        return $user->hasRole(['Super Administrador', 'Administrador']);
                    case 'manage-users':
                        return $user->hasRole('Super Administrador');
                    case 'system-config':
                        return $user->hasRole('Super Administrador');
                }
            }
            return $result;
        });
    }
}
