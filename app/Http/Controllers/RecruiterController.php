<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class RecruiterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recruiters = Recruiter::with(['company', 'person.residenceInformation.municipality.province'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('recruiters.index', compact('recruiters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruiters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos usando Gate
        Gate::authorize('create', Recruiter::class);

        $rules = [
            'registration_date' => 'required|date',
            'person_id' => 'required|exists:people,id',
            'branch' => 'nullable|string|max:255',
        ];

        // Si se proporciona company_id, validarlo
        if ($request->filled('company_id')) {
            $rules['company_id'] = 'required|exists:companies,id';
        }

        $validated = $request->validate($rules);

        try {
            $recruiter = Recruiter::create($validated);

            return redirect()
                ->route('recruiters.index')
                ->with('success', 'Reclutador registrado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al registrar el reclutador: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recruiter $recruiter)
    {
        $recruiter->load(['company', 'person.residenceInformation.municipality.province']);
        
        return view('recruiters.show', compact('recruiter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recruiter $recruiter)
    {
        $recruiter->load(['company', 'person']);
        
        return view('recruiters.edit', compact('recruiter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recruiter $recruiter)
    {
        // Verificar permisos usando Gate
        Gate::authorize('update', $recruiter);

        $rules = [
            'registration_date' => 'required|date',
            'person_id' => 'required|exists:people,id',
            'branch' => 'nullable|string|max:255',
        ];

        // Si se proporciona company_id, validarlo
        if ($request->filled('company_id')) {
            $rules['company_id'] = 'required|exists:companies,id';
        }

        $validated = $request->validate($rules);

        try {
            $recruiter->update($validated);

            return redirect()
                ->route('recruiters.index')
                ->with('success', 'Reclutador actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el reclutador: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recruiter $recruiter)
    {
        // Verificar permisos usando Gate
        Gate::authorize('delete', $recruiter);

        try {
            $recruiter->delete();

            return redirect()
                ->route('recruiters.index')
                ->with('success', 'Reclutador eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el reclutador: ' . $e->getMessage());
        }
    }

    /**
     * Buscar empresa por RNC (AJAX)
     */
    public function searchByRnc(Request $request)
    {
        $rnc = $request->input('rnc');
        
        if (empty($rnc)) {
            return response()->json(['error' => 'RNC no proporcionado'], 400);
        }

        $company = Company::with(['municipality.province', 'regional'])
            ->where('rnc', $rnc)
            ->first();

        if (!$company) {
            return response()->json(['error' => 'No se encontró una empresa con ese RNC'], 404);
        }

        return response()->json([
            'id' => $company->id,
            'business_name' => $company->business_name,
            'rnc' => $company->rnc,
            'branch' => $company->branch,
            'economic_activity' => $company->industry,
            'province' => $company->municipality->province->name ?? '',
            'municipality' => $company->municipality->name ?? '',
            'sector' => $company->sector,
            'phone' => $company->landline_phone,
            'extension' => $company->extension,
            'email' => $company->email,
            'regional_id' => $company->regional_id,
            'province_id' => $company->province_id,
            'municipality_id' => $company->municipality_id,
        ]);
    }

    /**
     * Buscar persona por cédula (AJAX)
     */
    public function searchByDni(Request $request)
    {
        $dni = $request->input('dni');
        
        if (empty($dni)) {
            return response()->json(['error' => 'Cédula no proporcionada'], 400);
        }

        $person = Person::where('dni', $dni)->first();

        if (!$person) {
            return response()->json(['error' => 'No se encontró una persona con esa cédula'], 404);
        }

        return response()->json([
            'id' => $person->id,
            'name' => $person->name,
            'last_name' => $person->last_name,
            'dni' => $person->dni,
            'cell_phone' => $person->cell_phone,
            'email' => $person->email,
        ]);
    }

    /**
     * Buscar empresas para reclutadores (AJAX)
     */
    public function searchCompanies(Request $request)
    {
        $search = $request->input('search');
        
        if (empty($search) || strlen($search) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Debe ingresar al menos 2 caracteres para buscar'
            ], 400);
        }

        $companies = Company::with(['province', 'municipality'])
            ->where(function($query) use ($search) {
                $query->where('code_unique', 'like', "%{$search}%")
                      ->orWhere('business_name', 'like', "%{$search}%")
                      ->orWhere('rnc', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        $formattedCompanies = $companies->map(function($company) {
            return [
                'id' => $company->id,
                'name' => $company->business_name,
                'code' => $company->code_unique,
                'rnc' => $company->rnc,
                'branch' => $company->branch,
                'industry' => $company->industry,
                'phone' => $company->landline_phone,
                'email' => $company->email,
                'province' => $company->province?->name,
                'municipality' => $company->municipality?->name,
                'sector' => $company->sector,
                'extension' => $company->extension,
                'representative_name' => $company->representative_name,
                'representative_phone' => $company->representative_mobile,
                'representative_email' => $company->representative_email,
                'display' => $company->business_name . ' - RNC: ' . $company->rnc
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedCompanies
        ]);
    }

    /**
     * Buscar personas para reclutadores (AJAX)
     */
    public function searchPeople(Request $request)
    {
        $search = $request->input('search');
        
        if (empty($search) || strlen($search) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Debe ingresar al menos 1 carácter para buscar'
            ], 400);
        }

        $people = Person::with(['residenceInformation.municipality.province'])
            ->where(function($query) use ($search) {
                $query->where('dni', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            })
            ->limit(10)
            ->get();

        $formattedPeople = $people->map(function($person) {
            return [
                'id' => $person->id,
                'name' => $person->name . ' ' . $person->last_name,
                'dni' => $person->dni,
                'previous_dni' => $person->previous_dni,
                'birth_date' => $person->birth_date,
                'birth_place' => $person->birth_place,
                'province' => $person->residenceInformation?->municipality?->province?->name,
                'municipality' => $person->residenceInformation?->municipality?->name,
                'display' => $person->name . ' ' . $person->last_name . ' - Cédula: ' . $person->dni
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedPeople
        ]);
    }

    /**
     * Exportar reclutadores seleccionados a PDF
     */
    public function exportToPdf(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'No hay registros seleccionados para exportar.');
        }

        // Cargar reclutadores con sus relaciones y mapear los datos
        $recruiters = Recruiter::with(['company', 'person.residenceInformation.municipality.province'])
            ->whereIn('id', $ids)
            ->get()
            ->map(function($recruiter) {
                return [
                    'code_unique' => $recruiter->code_unique ?? 'N/A',
                    'company_name' => $recruiter->company ? $recruiter->company->business_name : 'No aplica',
                    'person_name' => $recruiter->person->name . ' ' . $recruiter->person->last_name,
                    'dni' => $recruiter->person->dni ?? 'N/A',
                    'phone' => $recruiter->person->cell_phone ?? 'N/A',
                    'email' => $recruiter->person->email ?? 'N/A',
                    'province' => $recruiter->person->residenceInformation?->municipality?->province?->name ?? 'N/A',
                    'municipality' => $recruiter->person->residenceInformation?->municipality?->name ?? 'N/A',
                ];
            });
        
        $pdf = Pdf::loadView('recruiters.pdf', compact('recruiters'));
        
        return $pdf->stream('reclutadores_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
