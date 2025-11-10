<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\WorkIntegrity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyDashboardController extends Controller
{
    /**
     * Dashboard de la empresa
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->company_id) {
            return redirect()->route('login')
                ->with('error', 'No tienes una empresa asociada a tu cuenta.');
        }

        $company = $user->company;

        // Obtener estadísticas
        $totalPeople = Person::where('company_id', $user->company_id)->count();
        $totalWorkIntegrities = WorkIntegrity::whereHas('person', function($query) use ($user) {
            $query->where('company_id', $user->company_id);
        })->count();

        // Obtener personas recientes
        $recentPeople = Person::where('company_id', $user->company_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Obtener depuraciones recientes
        $recentWorkIntegrities = WorkIntegrity::whereHas('person', function($query) use ($user) {
            $query->where('company_id', $user->company_id);
        })
        ->with('person')
        ->orderBy('fecha', 'desc')
        ->limit(5)
        ->get();

        return view('company.dashboard', compact('company', 'totalPeople', 'totalWorkIntegrities', 'recentPeople', 'recentWorkIntegrities'));
    }
}
