<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission, string $model = null): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página.');
        }

        $user = Auth::user();

        // Si se proporciona un modelo específico, usar Gate con el modelo
        if ($model) {
            $modelClass = "App\\Models\\{$model}";
            
            if (!class_exists($modelClass)) {
                abort(500, "Modelo {$model} no encontrado.");
            }

            // Si es una acción de creación, pasar la clase del modelo
            if (in_array($permission, ['create', 'store'])) {
                if (!Gate::allows($permission, $modelClass)) {
                    abort(403, 'No tiene permisos para realizar esta acción.');
                }
            } else {
                // Para otras acciones, obtener el modelo de la ruta
                $modelInstance = $request->route($this->getModelParameterName($model));
                
                if (!$modelInstance) {
                    abort(404, 'Recurso no encontrado.');
                }

                if (!Gate::allows($permission, $modelInstance)) {
                    abort(403, 'No tiene permisos para realizar esta acción.');
                }
            }
        } else {
            // Verificar permiso usando Spatie Permission
            if (!$user->can($permission)) {
                abort(403, 'No tiene permisos para acceder a este módulo.');
            }
        }

        return $next($request);
    }

    /**
     * Obtener el nombre del parámetro del modelo en la ruta
     */
    private function getModelParameterName(string $model): string
    {
        return strtolower($model);
    }
}