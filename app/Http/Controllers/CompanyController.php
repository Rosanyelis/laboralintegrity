<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with(['province', 'municipality', 'regional'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::with('regional')->orderBy('name')->get();
        
        return view('companies.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_date' => 'required|date',
            'business_name' => 'required|string|max:255',
            'branch' => 'nullable|string|max:255',
            'rnc' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'sector' => 'nullable|string|max:255',
            'landline_phone' => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'representative_name' => 'nullable|string|max:255',
            'representative_dni' => 'nullable|string|max:255',
            'representative_mobile' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
        ], [
            'registration_date.required' => 'La fecha de registro es obligatoria.',
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'province_id.required' => 'La provincia es obligatoria.',
            'province_id.exists' => 'La provincia seleccionada no es válida.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'representative_email.email' => 'El correo electrónico del representante debe ser una dirección válida.',
        ]);

        // Obtener el regional_id desde la provincia seleccionada
        $province = Province::find($validated['province_id']);
        $validated['regional_id'] = $province->regional_id;

        Company::create($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load(['province', 'municipality', 'regional']);
        
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $provinces = Province::with('regional')->orderBy('name')->get();
        $municipalities = Municipality::where('province_id', $company->province_id)->orderBy('name')->get();
        
        return view('companies.edit', compact('company', 'provinces', 'municipalities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'registration_date' => 'required|date',
            'business_name' => 'required|string|max:255',
            'branch' => 'nullable|string|max:255',
            'rnc' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'sector' => 'nullable|string|max:255',
            'landline_phone' => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'representative_name' => 'nullable|string|max:255',
            'representative_dni' => 'nullable|string|max:255',
            'representative_mobile' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
        ], [
            'registration_date.required' => 'La fecha de registro es obligatoria.',
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'province_id.required' => 'La provincia es obligatoria.',
            'province_id.exists' => 'La provincia seleccionada no es válida.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'representative_email.email' => 'El correo electrónico del representante debe ser una dirección válida.',
        ]);

        // Obtener el regional_id desde la provincia seleccionada
        $province = Province::find($validated['province_id']);
        $validated['regional_id'] = $province->regional_id;

        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $companyName = $company->business_name;
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', "Empresa \"{$companyName}\" eliminada correctamente.");
    }

    /**
     * Obtener los municipios de una provincia (para AJAX).
     */
    public function getMunicipalities($provinceId)
    {
        $municipalities = Municipality::where('province_id', $provinceId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($municipalities);
    }

    /**
     * Verificar si un RNC ya existe (para AJAX).
     */
    public function checkRnc($rnc)
    {
        $company = Company::where('rnc', $rnc)->first();

        if ($company) {
            return response()->json([
                'exists' => true,
                'company' => [
                    'id' => $company->id,
                    'business_name' => $company->business_name,
                    'rnc' => $company->rnc,
                    'branch' => $company->branch,
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Exportar empresas seleccionadas a PDF
     */
    public function exportToPdf(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'No hay registros seleccionados para exportar.');
        }

        // Cargar empresas con sus relaciones y mapear los datos
        $companies = Company::with(['province', 'municipality'])
            ->whereIn('id', $ids)
            ->get()
            ->map(function($company) {
                return [
                    'code_unique' => $company->code_unique ?? 'N/A',
                    'business_name' => $company->business_name ?? 'N/A',
                    'rnc' => $company->rnc ?? 'N/A',
                    'province' => $company->province?->name ?? 'N/A',
                    'municipality' => $company->municipality?->name ?? 'N/A',
                    'representative_name' => $company->representative_name ?? 'N/A',
                    'landline_phone' => $company->landline_phone ?? 'N/A',
                    'representative_email' => $company->representative_email ?? 'N/A',
                ];
            });
        
        $pdf = Pdf::loadView('companies.pdf', compact('companies'));
        
        return $pdf->stream('empresas_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
