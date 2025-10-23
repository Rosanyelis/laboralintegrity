<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a este módulo.');
        }

        $user = Auth::user();

        // Verificar si el usuario tiene rol de administrador
        if (!$user->hasRole(['Super Administrador', 'Administrador'])) {
            abort(403, 'No tiene permisos para acceder al módulo de configuraciones.');
        }

        return $next($request);
    }
}