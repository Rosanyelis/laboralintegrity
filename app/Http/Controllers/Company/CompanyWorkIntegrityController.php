<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\WorkIntegrity;
use App\Models\WorkIntegrityItem;
use App\Models\Person;
use App\Models\Certification;
use App\Models\ReferenceCode;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyWorkIntegrityController extends Controller
{
    public function __construct()
    {
        // Las políticas se aplicarán automáticamente en cada método
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Obtener depuraciones agrupadas por persona, solo de personas de la empresa
        $workIntegrities = WorkIntegrity::with(['person.residenceInformation.province', 'person.residenceInformation.municipality'])
            ->whereHas('person', function($query) use ($user) {
                $query->where('company_id', $user->company_id);
            })
            ->select('person_id', 'person_dni', 'person_name')
            ->selectRaw('COUNT(*) as total_integraciones')
            ->selectRaw('MAX(fecha) as ultima_fecha')
            ->groupBy('person_id', 'person_dni', 'person_name')
            ->orderBy('ultima_fecha', 'desc')
            ->get();
        
        return view('company.work-integrities.index', compact('workIntegrities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        
        $certifications = Certification::orderBy('id', 'asc')->get();
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        $provinces = Province::with('regional')->orderBy('name')->get();
        
        // Solo cargar personas de la empresa del usuario
        $people = Person::where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();
        
        // Si se pasa un person_id, cargar la persona (verificando que pertenezca a la empresa)
        $selectedPerson = null;
        if ($request->has('person_id')) {
            $selectedPerson = Person::where('company_id', $user->company_id)
                ->find($request->person_id);
        }
        
        return view('company.work-integrities.create', compact('certifications', 'referenceCodes', 'provinces', 'selectedPerson', 'people'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'fecha' => 'required|date|before_or_equal:today',
            'resultado' => 'nullable|string',
            'company_id' => 'nullable|exists:companies,id',
            'company_code' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_branch' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'company_email' => 'nullable|email',
            'representative_name' => 'nullable|string',
            'representative_phone' => 'nullable|string',
            'representative_email' => 'nullable|email',
            'person_id' => 'required|exists:people,id',
            'person_dni' => 'required|string',
            'person_name' => 'required|string',
            'previous_dni' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string',
            'province' => 'nullable|string',
            'municipality' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.certification_id' => 'nullable|exists:certifications,id',
            'items.*.reference_code_id' => 'required|exists:reference_codes,id',
            'items.*.reference_code' => 'required|string',
            'items.*.reference_name' => 'required|string',
            'items.*.actual_result' => 'nullable|string',
            'items.*.evaluation_detail' => 'nullable|string',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'person_id.required' => 'Debe seleccionar una persona.',
            'person_id.exists' => 'La persona seleccionada no existe.',
            'items.required' => 'Debe agregar al menos un item de depuración.',
            'items.min' => 'Debe agregar al menos un item de depuración.',
        ]);

        // Verificar que la persona pertenezca a la empresa del usuario
        $person = Person::findOrFail($validated['person_id']);
        if ($person->company_id !== $user->company_id) {
            return back()->withInput()
                ->with('error', 'No tienes permiso para crear depuraciones para esta persona.');
        }

        // Asignar automáticamente el company_id de la empresa del usuario
        $validated['company_id'] = $user->company_id;

        DB::beginTransaction();
        try {
            // Crear el registro principal
            $workIntegrity = WorkIntegrity::create([
                'fecha' => $validated['fecha'],
                'resultado' => $validated['resultado'] ?? null,
                'company_id' => $validated['company_id'],
                'company_code' => $validated['company_code'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'company_branch' => $validated['company_branch'] ?? null,
                'company_phone' => $validated['company_phone'] ?? null,
                'company_email' => $validated['company_email'] ?? null,
                'representative_name' => $validated['representative_name'] ?? null,
                'representative_phone' => $validated['representative_phone'] ?? null,
                'representative_email' => $validated['representative_email'] ?? null,
                'person_id' => $validated['person_id'],
                'person_dni' => $validated['person_dni'],
                'person_name' => $validated['person_name'],
                'previous_dni' => $validated['previous_dni'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'birth_place' => $validated['birth_place'] ?? null,
                'province' => $validated['province'] ?? null,
                'municipality' => $validated['municipality'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Crear los items
            foreach ($validated['items'] as $item) {
                $workIntegrity->items()->create([
                    'certification_id' => $item['certification_id'] ?? null,
                    'reference_code_id' => $item['reference_code_id'],
                    'reference_code' => $item['reference_code'],
                    'reference_name' => $item['reference_name'],
                    'actual_result' => $item['actual_result'] ?? null,
                    'evaluation_detail' => $item['evaluation_detail'] ?? null,
                ]);
            }

            // Actualizar el estado de verificación de la persona
            $person->updateVerificationStatus();

            DB::commit();

            return redirect()->route('company.work-integrities.index')
                ->with('success', 'Depuración creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el registro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkIntegrity $workIntegrity)
    {
        $workIntegrity->load(['items.certification', 'person', 'company', 'creator']);
        
        return view('company.work-integrities.show', compact('workIntegrity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkIntegrity $workIntegrity)
    {
        $user = auth()->user();
        
        $certifications = Certification::orderBy('id', 'asc')->get();
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        $provinces = Province::with('regional')->orderBy('name')->get();
        
        // Solo cargar personas de la empresa del usuario
        $people = Person::where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();
        
        $workIntegrity->load(['items.certification', 'person']);
        
        return view('company.work-integrities.edit', compact('workIntegrity', 'certifications', 'referenceCodes', 'provinces', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkIntegrity $workIntegrity)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'fecha' => 'required|date|before_or_equal:today',
            'resultado' => 'nullable|string',
            'company_code' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_branch' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'company_email' => 'nullable|email',
            'representative_name' => 'nullable|string',
            'representative_phone' => 'nullable|string',
            'representative_email' => 'nullable|email',
            'items' => 'required|array|min:1',
            'items.*.certification_id' => 'nullable|exists:certifications,id',
            'items.*.reference_code_id' => 'required|exists:reference_codes,id',
            'items.*.reference_code' => 'required|string',
            'items.*.reference_name' => 'required|string',
            'items.*.actual_result' => 'nullable|string',
            'items.*.evaluation_detail' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar el registro principal
            $workIntegrity->update([
                'fecha' => $validated['fecha'],
                'resultado' => $validated['resultado'] ?? null,
                'company_code' => $validated['company_code'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'company_branch' => $validated['company_branch'] ?? null,
                'company_phone' => $validated['company_phone'] ?? null,
                'company_email' => $validated['company_email'] ?? null,
                'representative_name' => $validated['representative_name'] ?? null,
                'representative_phone' => $validated['representative_phone'] ?? null,
                'representative_email' => $validated['representative_email'] ?? null,
            ]);

            // Eliminar items existentes
            $workIntegrity->items()->delete();

            // Crear los nuevos items
            foreach ($validated['items'] as $item) {
                $workIntegrity->items()->create([
                    'certification_id' => $item['certification_id'] ?? null,
                    'reference_code_id' => $item['reference_code_id'],
                    'reference_code' => $item['reference_code'],
                    'reference_name' => $item['reference_name'],
                    'actual_result' => $item['actual_result'] ?? null,
                    'evaluation_detail' => $item['evaluation_detail'] ?? null,
                ]);
            }

            // Actualizar el estado de verificación de la persona
            if ($workIntegrity->person) {
                $workIntegrity->person->updateVerificationStatus();
            }

            DB::commit();

            return redirect()->route('company.work-integrities.show', $workIntegrity)
                ->with('success', 'Depuración actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkIntegrity $workIntegrity)
    {
        $person = $workIntegrity->person;
        
        $workIntegrity->delete();

        // Actualizar el estado de verificación de la persona
        if ($person) {
            $person->updateVerificationStatus();
        }

        return redirect()->route('company.work-integrities.index')
            ->with('success', 'Depuración eliminada correctamente.');
    }
}
