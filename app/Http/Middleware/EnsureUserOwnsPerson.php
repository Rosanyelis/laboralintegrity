<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserOwnsPerson
{
    /**
     * Handle an incoming request.
     * Verifica que el usuario autenticado solo pueda acceder a su propia información personal.
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

        // Verificar que el usuario tenga una persona asociada
        if (!$user->person_id) {
            abort(403, 'No tienes una persona asociada a tu cuenta.');
        }

        // Si hay un parámetro {person} en la ruta, verificar que sea la del usuario
        if ($request->route('person')) {
            $person = $request->route('person');
            
            // Si es un ID, obtener el modelo
            if (is_numeric($person)) {
                $person = \App\Models\Person::findOrFail($person);
            }
            
            // Verificar que la persona pertenezca al usuario
            if ($person->id !== $user->person_id) {
                abort(403, 'No tienes permiso para acceder a esta información.');
            }
        }

        return $next($request);
    }
}
