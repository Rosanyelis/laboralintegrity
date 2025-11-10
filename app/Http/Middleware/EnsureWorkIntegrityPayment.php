<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureWorkIntegrityPayment
{
    /**
     * Handle an incoming request.
     * Verifica que el usuario tenga acceso al módulo de depuraciones.
     * Super Administrador y Administrador siempre tienen acceso.
     * Usuarios empresa necesitan tener pago activo.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Verificar que el usuario esté autenticado
        if (!$user) {
            return redirect()->route('login');
        }

        // Super Administrador y Administrador siempre tienen acceso
        if ($user->hasRole('Super Administrador') || $user->hasRole('Administrador')) {
            return $next($request);
        }

        // Para usuarios empresa, verificar si tienen pago activo
        if ($user->company_id && !$user->has_work_integrity_payment) {
            abort(403, 'El módulo de depuraciones requiere un pago activo. Por favor, contacte al administrador para habilitar este módulo.');
        }

        return $next($request);
    }
}

