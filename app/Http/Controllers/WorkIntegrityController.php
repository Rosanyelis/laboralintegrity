<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkIntegrity;
use App\Models\WorkIntegrityItem;
use App\Models\Company;
use App\Models\Person;
use App\Models\Certification;
use App\Models\ReferenceCode;
use Illuminate\Support\Facades\DB;

class WorkIntegrityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workIntegrities = WorkIntegrity::with(['person.residenceInformation.province', 'person.residenceInformation.municipality', 'company'])
            ->orderBy('fecha', 'desc')
            ->get();
        
        return view('work-integrities.index', compact('workIntegrities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $certifications = Certification::orderBy('name')->get();
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        
        // Si se pasa un person_id, cargar la persona
        $selectedPerson = null;
        if ($request->has('person_id')) {
            $selectedPerson = Person::find($request->person_id);
        }
        
        return view('work-integrities.create', compact('certifications', 'referenceCodes', 'selectedPerson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
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
            'items.*.evaluation_detail' => 'nullable|string',
            'return_to_people' => 'nullable|string',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'person_id.required' => 'Debe seleccionar una persona.',
            'person_id.exists' => 'La persona seleccionada no existe.',
            'items.required' => 'Debe agregar al menos un item de depuración.',
            'items.min' => 'Debe agregar al menos un item de depuración.',
        ]);

        DB::beginTransaction();
        try {
            // Crear el registro principal
            $workIntegrity = WorkIntegrity::create([
                'fecha' => $validated['fecha'],
                'resultado' => $validated['resultado'] ?? null,
                'company_id' => $validated['company_id'] ?? null,
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
                    'evaluation_detail' => $item['evaluation_detail'] ?? null,
                ]);
            }

            // Actualizar el estado de verificación de la persona
            $person = Person::find($validated['person_id']);
            if ($person) {
                $person->updateVerificationStatus();
            }

            DB::commit();

            // Si viene del módulo de personas, redirigir allí
            if (!empty($validated['return_to_people'])) {
                return redirect()->route('people.index')
                    ->with('success', 'Depuración creada correctamente.');
            }

            return redirect()->route('work-integrities.index')
                ->with('success', 'Registro de integridad laboral creado correctamente.');
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
        
        return view('work-integrities.show', compact('workIntegrity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkIntegrity $workIntegrity)
    {
        $workIntegrity->load('items.certification');
        $certifications = Certification::orderBy('name')->get();
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        
        // Transformar items para JavaScript
        $items = $workIntegrity->items->map(function($item) {
            return [
                'certification_id' => $item->certification_id,
                'reference_code_id' => $item->reference_code_id,
                'reference_code' => $item->reference_code,
                'reference_name' => $item->reference_name,
                'evaluation_detail' => $item->evaluation_detail,
            ];
        });
        
        return view('work-integrities.edit', compact('workIntegrity', 'certifications', 'referenceCodes', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkIntegrity $workIntegrity)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
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
            'items.*.evaluation_detail' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar el registro principal
            $workIntegrity->update([
                'fecha' => $validated['fecha'],
                'resultado' => $validated['resultado'] ?? null,
                'company_id' => $validated['company_id'] ?? null,
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
            ]);

            // Eliminar items antiguos y crear nuevos
            $workIntegrity->items()->delete();
            foreach ($validated['items'] as $item) {
                $workIntegrity->items()->create([
                    'certification_id' => $item['certification_id'] ?? null,
                    'reference_code_id' => $item['reference_code_id'],
                    'reference_code' => $item['reference_code'],
                    'reference_name' => $item['reference_name'],
                    'evaluation_detail' => $item['evaluation_detail'] ?? null,
                ]);
            }

            // Actualizar el estado de verificación de la persona
            $person = Person::find($validated['person_id']);
            if ($person) {
                $person->updateVerificationStatus();
            }

            DB::commit();

            return redirect()->route('work-integrities.index')
                ->with('success', 'Registro de integridad laboral actualizado correctamente.');
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
        try {
            $personId = $workIntegrity->person_id;
            
            $workIntegrity->delete();

            // Actualizar el estado de verificación de la persona después de eliminar
            $person = Person::find($personId);
            if ($person) {
                $person->updateVerificationStatus();
            }

            return redirect()->route('work-integrities.index')
                ->with('success', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Buscar empresa por RNC
     */
    public function searchCompanyByRnc(Request $request)
    {
        $rnc = $request->get('rnc');
        $company = Company::where('rnc', $rnc)->first();
        
        if ($company) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $company->id,
                    'code' => $company->code_unique ?? $company->rnc,
                    'name' => $company->business_name,
                    'branch' => $company->branch ?? 'Sede Central',
                    'phone' => $company->landline_phone ?? '',
                    'email' => $company->email ?? '',
                    'representative_name' => $company->representative_name ?? '',
                    'representative_phone' => $company->representative_mobile ?? '',
                    'representative_email' => $company->representative_email ?? '',
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No se encontró ninguna empresa con este RNC.'
        ], 404);
    }

    /**
     * Buscar persona por DNI
     */
    public function searchPersonByDni(Request $request)
    {
        $dni = $request->get('dni');
        $person = Person::with(['residenceInformation.province', 'residenceInformation.municipality'])
            ->where('dni', $dni)
            ->first();
        
        if ($person) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $person->id,
                    'dni' => $person->dni,
                    'name' => $person->name . ' ' . $person->last_name,
                    'previous_dni' => $person->previous_dni,
                    'birth_date' => $person->birth_date?->format('Y-m-d'),
                    'birth_place' => $person->birth_place,
                    'province' => $person->residenceInformation?->province?->name ?? '',
                    'municipality' => $person->residenceInformation?->municipality?->name ?? '',
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No se encontró ninguna persona con esta cédula.'
        ], 404);
    }

    /**
     * Obtener códigos de referencia
     */
    public function getReferenceCodesByCertification(Request $request)
    {
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        
        return response()->json([
            'success' => true,
            'data' => $referenceCodes->map(function($code) {
                return [
                    'id' => $code->id,
                    'code' => $code->code,
                    'result' => $code->result,
                    'value' => $code->id,
                    'text' => $code->code . ' - ' . $code->result,
                ];
            })
        ]);
    }
}
