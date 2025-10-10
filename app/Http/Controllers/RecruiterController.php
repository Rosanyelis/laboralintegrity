<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
