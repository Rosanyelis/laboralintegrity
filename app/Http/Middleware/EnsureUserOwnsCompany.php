<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserOwnsCompany
{
    /**
     * Handle an incoming request.
     * Verifica que el usuario autenticado tenga una empresa asociada y solo pueda acceder a recursos de su empresa.
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

        // Verificar que el usuario tenga una empresa asociada
        if (!$user->company_id) {
            abort(403, 'No tienes una empresa asociada a tu cuenta.');
        }

        // Si hay un parámetro {person} en la ruta, verificar que pertenezca a la empresa
        if ($request->route('person')) {
            $person = $request->route('person');
            
            // Si es un ID, obtener el modelo
            if (is_numeric($person)) {
                $person = \App\Models\Person::findOrFail($person);
            }
            
            // Verificar que la persona pertenezca a la empresa del usuario
            if ($person->company_id !== $user->company_id) {
                abort(403, 'No tienes permiso para acceder a esta información.');
            }
        }

        // Si hay un parámetro {workIntegrity} en la ruta, verificar que pertenezca a la empresa
        if ($request->route('workIntegrity')) {
            $workIntegrity = $request->route('workIntegrity');
            
            // Si es un ID, obtener el modelo
            if (is_numeric($workIntegrity)) {
                $workIntegrity = \App\Models\WorkIntegrity::findOrFail($workIntegrity);
            }
            
            // Verificar que la depuración pertenezca a una persona de la empresa del usuario
            if ($workIntegrity->person->company_id !== $user->company_id) {
                abort(403, 'No tienes permiso para acceder a esta información.');
            }
        }

        return $next($request);
    }
}
