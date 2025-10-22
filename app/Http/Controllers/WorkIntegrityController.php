<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkIntegrity;
use App\Models\WorkIntegrityItem;
use App\Models\Company;
use App\Models\Person;
use App\Models\Certification;
use App\Models\ReferenceCode;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class WorkIntegrityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener datos agrupados por persona con conteo de integraciones
        $workIntegrities = WorkIntegrity::with(['person.residenceInformation.province', 'person.residenceInformation.municipality'])
            ->select('person_id', 'person_dni', 'person_name')
            ->selectRaw('COUNT(*) as total_integraciones')
            ->selectRaw('MAX(fecha) as ultima_fecha')
            ->groupBy('person_id', 'person_dni', 'person_name')
            ->orderBy('ultima_fecha', 'desc')
            ->get();
        
        return view('work-integrities.index', compact('workIntegrities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $certifications = Certification::orderBy('id', 'asc')->get();
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        $provinces = Province::with('regional')->orderBy('name')->get();
        
        // Si se pasa un person_id, cargar la persona
        $selectedPerson = null;
        if ($request->has('person_id')) {
            $selectedPerson = Person::find($request->person_id);
        }
        
        return view('work-integrities.create', compact('certifications', 'referenceCodes', 'provinces', 'selectedPerson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos usando Gate
        Gate::authorize('create', WorkIntegrity::class);

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
            'items.*.actual_result' => 'nullable|string',
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
                    'actual_result' => $item['actual_result'] ?? null,
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
                'certification_name' => $item->certification?->name ?? 'N/A',
                'reference_code_id' => $item->reference_code_id,
                'reference_code' => $item->reference_code,
                'reference_name' => $item->reference_name,
                'actual_result' => $item->actual_result,
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
        // Verificar permisos usando Gate
        Gate::authorize('update', $workIntegrity);

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
            'items.*.actual_result' => 'nullable|string',
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
                    'actual_result' => $item['actual_result'] ?? null,
                    'evaluation_detail' => $item['evaluation_detail'] ?? null,
                ]);
            }

            // Actualizar el estado de verificación de la persona
            $person = Person::find($validated['person_id']);
            if ($person) {
                $person->updateVerificationStatus();
            }

            DB::commit();

            // Si viene de un perfil de persona, redirigir allí
            if ($request->has('return_to_person')) {
                return redirect()->route('people.show', ['person' => $request->return_to_person, 'activeTab' => 'depuraciones'])
                    ->with('success', 'Registro de integridad laboral actualizado correctamente.');
            }

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
    public function destroy(Request $request, WorkIntegrity $workIntegrity)
    {
        // Verificar permisos usando Gate
        Gate::authorize('delete', $workIntegrity);

        try {
            $personId = $workIntegrity->person_id;
            
            $workIntegrity->delete();

            // Actualizar el estado de verificación de la persona después de eliminar
            $person = Person::find($personId);
            if ($person) {
                $person->updateVerificationStatus();
            }

            // Si viene de un perfil de persona, redirigir allí
            if ($request->has('return_to_person')) {
                return redirect()->route('people.show', ['person' => $request->return_to_person, 'activeTab' => 'depuraciones'])
                    ->with('success', 'Registro eliminado correctamente.');
            }

            return redirect()->route('work-integrities.index')
                ->with('success', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Buscar empresas para autocompletado
     */
    public function searchCompanies(Request $request)
    {
        $search = $request->get('search', '');
        
        if (strlen($search) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        // Buscar por RNC, code_unique o nombre de empresa (máximo 10 resultados)
        $companies = Company::where('rnc', 'like', '%' . $search . '%')
            ->orWhere('code_unique', 'like', '%' . $search . '%')
            ->orWhere('business_name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->map(function($company) {
                return [
                    'id' => $company->id,
                    'rnc' => $company->rnc,
                    'code' => $company->code_unique ?? $company->rnc,
                    'name' => $company->business_name,
                    'display' => ($company->code_unique ? $company->code_unique . ' - ' : '') . $company->rnc . ' - ' . $company->business_name,
                    'branch' => $company->branch ?? 'Sede Central',
                    'phone' => $company->landline_phone ?? '',
                    'email' => $company->email ?? '',
                    'representative_name' => $company->representative_name ?? '',
                    'representative_phone' => $company->representative_mobile ?? '',
                    'representative_email' => $company->representative_email ?? '',
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $companies
        ]);
    }

    /**
     * Buscar empresa por RNC o nombre
     */
    public function searchCompanyByRnc(Request $request)
    {
        $search = $request->get('rnc');
        
        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Debe proporcionar un término de búsqueda.'
            ], 400);
        }
        
        // Buscar por RNC, code_unique o nombre de empresa (parcial)
        $company = Company::where('rnc', 'like', '%' . $search . '%')
            ->orWhere('code_unique', 'like', '%' . $search . '%')
            ->orWhere('business_name', 'like', '%' . $search . '%')
            ->first();
        
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
            'message' => 'No se encontró ninguna empresa con este RNC o nombre.'
        ], 404);
    }

    /**
     * Crear nueva empresa desde el formulario de integridad laboral
     */
    public function createCompany(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'rnc' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
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
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'business_name.unique' => 'Ya existe una empresa con este nombre.',
            'rnc.unique' => 'Ya existe una empresa con este RNC.',
            'province_id.required' => 'La provincia es obligatoria.',
            'province_id.exists' => 'La provincia seleccionada no es válida.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'representative_email.email' => 'El correo electrónico del representante debe ser una dirección válida.',
        ]);

        // Validar que no exista una empresa con el mismo nombre o RNC
        $existingCompany = Company::where('business_name', $validated['business_name'])
            ->orWhere(function($query) use ($validated) {
                if (!empty($validated['rnc'])) {
                    $query->where('rnc', $validated['rnc']);
                }
            })
            ->first();

        if ($existingCompany) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una empresa con este nombre o RNC.',
                'existing_company' => [
                    'id' => $existingCompany->id,
                    'business_name' => $existingCompany->business_name,
                    'rnc' => $existingCompany->rnc,
                ]
            ], 422);
        }

        // Obtener el regional_id desde la provincia seleccionada
        $province = Province::find($validated['province_id']);
        $validated['regional_id'] = $province->regional_id;
        $validated['registration_date'] = now()->toDateString();

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Empresa creada correctamente.',
            'company' => [
                'id' => $company->id,
                'rnc' => $company->rnc,
                'code' => $company->code_unique ?? $company->rnc,
                'name' => $company->business_name,
                'display' => ($company->code_unique ? $company->code_unique . ' - ' : '') . $company->rnc . ' - ' . $company->business_name,
                'branch' => $company->branch ?? 'Sede Central',
                'phone' => $company->landline_phone ?? '',
                'email' => $company->email ?? '',
                'representative_name' => $company->representative_name ?? '',
                'representative_phone' => $company->representative_mobile ?? '',
                'representative_email' => $company->representative_email ?? '',
            ]
        ]);
    }

    /**
     * Crear nueva persona desde el formulario de integridad laboral
     */
    public function createPerson(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:people,dni',
                'previous_dni' => 'nullable|string|max:20',
                'birth_date' => 'required|date|before:today',
                'birth_place' => 'required|string|max:255',
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'last_name.required' => 'Los apellidos son obligatorios.',
                'dni.required' => 'La cédula es obligatoria.',
                'dni.unique' => 'Ya existe una persona con esta cédula.',
                'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
                'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
                'birth_place.required' => 'El lugar de nacimiento es obligatorio.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->validator->errors()
            ], 422);
        }

        // Validar que no exista una persona con la misma cédula
        $existingPerson = Person::where('dni', $validated['dni'])->first();

        if ($existingPerson) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una persona con esta cédula.',
                'existing_person' => [
                    'id' => $existingPerson->id,
                    'name' => $existingPerson->name,
                    'last_name' => $existingPerson->last_name,
                    'dni' => $existingPerson->dni,
                ]
            ], 422);
        }

        try {
            // Generar código único y calcular edad
            $validated['code_unique'] = $this->generatePersonCode();
            $validated['age'] = \Carbon\Carbon::parse($validated['birth_date'])->age;
            
            // Agregar valores por defecto para campos requeridos que no están en el modal
            $validated['country'] = 'República Dominicana'; // Valor por defecto
            $validated['email'] = 'temp-' . time() . '-' . rand(1000, 9999) . '@temporal.com'; // Email temporal único
            $validated['user_id'] = auth()->id(); // Usuario actual

            $person = Person::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Persona creada correctamente.',
                'person' => [
                    'id' => $person->id,
                    'name' => $person->name,
                    'last_name' => $person->last_name,
                    'dni' => $person->dni,
                    'previous_dni' => $person->previous_dni,
                    'birth_date' => $person->birth_date->format('Y-m-d'),
                    'birth_place' => $person->birth_place,
                    'province' => '',
                    'municipality' => '',
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al crear persona: ' . $e->getMessage(), [
                'data' => $validated,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar código único para persona
     */
    private function generatePersonCode()
    {
        $date = now()->format('dmY');
        $lastPerson = Person::orderBy('id', 'desc')->first();
        $sequence = $lastPerson ? $lastPerson->id + 1 : 1;
        return str_pad($sequence, 2, '0', STR_PAD_LEFT) . '-' . $date;
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
     * Buscar personas para autocompletado
     */
    public function searchPeople(Request $request)
    {
        $search = $request->get('search', '');
        
        if (strlen($search) < 3) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        // Buscar por DNI o nombre (máximo 10 resultados)
        $people = Person::with(['residenceInformation.province', 'residenceInformation.municipality'])
            ->where('dni', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->map(function($person) {
                return [
                    'id' => $person->id,
                    'dni' => $person->dni,
                    'name' => $person->name . ' ' . $person->last_name,
                    'display' => $person->dni . ' - ' . $person->name . ' ' . $person->last_name,
                    'previous_dni' => $person->previous_dni,
                    'birth_date' => $person->birth_date?->format('Y-m-d'),
                    'birth_place' => $person->birth_place,
                    'province' => $person->residenceInformation?->province?->name ?? '',
                    'municipality' => $person->residenceInformation?->municipality?->name ?? '',
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $people
        ]);
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

    /**
     * Display a listing of work integrities for a specific person.
     */
    public function showPersonIntegrations(Person $person)
    {
        // Verificar permisos usando Gate
        Gate::authorize('viewAny', WorkIntegrity::class);

        $workIntegrities = WorkIntegrity::where('person_id', $person->id)
            ->with(['company', 'items.referenceCode', 'items.certification'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('work-integrities.person_integrations', compact('person', 'workIntegrities'));
    }
}
