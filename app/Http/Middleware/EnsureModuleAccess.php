<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a este módulo.');
        }

        $user = Auth::user();

        // Definir los permisos requeridos para cada módulo
        $modulePermissions = [
            'people' => ['people.index', 'people.show'],
            'companies' => ['companies.index', 'companies.show'],
            'work-integrities' => ['work-integrities.index', 'work-integrities.show'],
            'certifications' => ['certifications.index', 'certifications.show'],
            'reference-codes' => ['reference-codes.index', 'reference-codes.show'],
            'roles' => ['roles.index', 'roles.show'],
            'recruiters' => ['recruiters.index', 'recruiters.show'],
            'dashboard' => ['dashboard.view'],
        ];

        // Verificar si el módulo existe en la configuración
        if (!isset($modulePermissions[$module])) {
            abort(500, "Módulo '{$module}' no configurado.");
        }

        // Verificar si el usuario tiene al menos uno de los permisos requeridos
        $hasPermission = false;
        foreach ($modulePermissions[$module] as $permission) {
            if ($user->can($permission)) {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            abort(403, "No tiene permisos para acceder al módulo de {$module}.");
        }

        return $next($request);
    }
}