<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\District;
use App\Models\Municipality;
use App\Models\EducationalSkill;
use App\Models\WorkExperience;
use App\Models\PersonalReference;
use App\Models\Aspiration;
use App\Models\ResidenceInformation;
use App\Http\Requests\Person\StorePersonCompanyRequest;
use App\Http\Requests\Person\UpdatePersonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CompanyPersonController extends Controller
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
        
        $people = Person::where('company_id', $user->company_id)
            ->with('aspiration')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('company.people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.people.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonCompanyRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();
        
        // Asignar automáticamente el company_id
        $validated['company_id'] = $user->company_id;
        
        // Generar código único
        $lastConsecutive = Person::getLastConsecutiveNumber();
        $consecutiveNumber = str_pad($lastConsecutive + 1, 2, '0', STR_PAD_LEFT);
        $validated['code_unique'] = $consecutiveNumber . '-' . now()->format('dmY');

        // Calcular edad si no se proporcionó
        if (!isset($validated['age']) && isset($validated['birth_date'])) {
            $birthDate = \Carbon\Carbon::parse($validated['birth_date']);
            $validated['age'] = $birthDate->age;
        }

        // Crear la persona
        $person = Person::create($validated);

        return redirect()->route('company.people.index')
            ->with('success', 'Persona registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        $person->load([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
            'workIntegrities.items.referenceCode',
            'workIntegrities.items.certification',
        ]);
        
        $districts = District::with(['municipality.province.regional'])
            ->whereHas('municipality', function($query) {
                $query->whereHas('province', function($query) {
                    $query->whereHas('regional');
                });
            })
            ->orderBy('name')
            ->get();
            
        $municipalities = Municipality::with(['province.regional'])
            ->whereHas('province', function($query) {
                $query->whereHas('regional');
            })
            ->orderBy('name')
            ->get();

        return view('company.people.show', compact('person', 'districts', 'municipalities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        $person->load([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ]);
        
        $districts = District::with(['municipality.province.regional'])
            ->whereHas('municipality', function($query) {
                $query->whereHas('province', function($query) {
                    $query->whereHas('regional');
                });
            })
            ->orderBy('name')
            ->get();
            
        $municipalities = Municipality::with(['province.regional'])
            ->whereHas('province', function($query) {
                $query->whereHas('regional');
            })
            ->orderBy('name')
            ->get();

        return view('company.people.edit', compact('person', 'districts', 'municipalities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        $validated = $request->validated();

        // Calcular edad si cambió la fecha de nacimiento
        if (isset($validated['birth_date']) && !isset($validated['age'])) {
            $birthDate = \Carbon\Carbon::parse($validated['birth_date']);
            $validated['age'] = $birthDate->age;
        }

        $person->update($validated);

        // Actualizar información de residencia
        if ($request->filled('municipality_id')) {
            $municipality = Municipality::with(['province.regional'])->find($request->municipality_id);
            
            $residenceData = [
                'province_id' => $municipality->province->id,
                'municipality_id' => $request->municipality_id,
                'sector' => $validated['sector'] ?? null,
                'neighborhood' => $validated['neighborhood'] ?? null,
                'street_and_number' => $validated['street_and_number'] ?? null,
                'arrival_reference' => $validated['arrival_reference'] ?? null,
            ];

            if ($request->filled('district_id') && $request->district_id !== 'no_aplica') {
                $residenceData['district_id'] = $request->district_id;
            } else {
                $residenceData['district_id'] = null;
            }

            $person->residenceInformation()->updateOrCreate(
                ['person_id' => $person->id],
                $residenceData
            );
        }

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('company.people.index')
            ->with('success', 'Persona eliminada exitosamente.');
    }

    /**
     * Actualiza o crea las aspiraciones de una persona.
     */
    public function updateAspiration(Request $request, Person $person)
    {
        // Normalizar valores de campos con validación 'in:' a minúsculas antes de validar
        // Esto evita errores cuando los valores vienen con mayúsculas desde el formulario
        $requestData = $request->all();
        
        // Normalizar campos opcionales
        if (isset($requestData['contract_type_preference']) && !empty($requestData['contract_type_preference'])) {
            $requestData['contract_type_preference'] = strtolower($requestData['contract_type_preference']);
        }
        
        if (isset($requestData['turno']) && !empty($requestData['turno'])) {
            $requestData['turno'] = strtolower($requestData['turno']);
        }
        
        // Normalizar campos obligatorios también
        if (isset($requestData['employment_status']) && !empty($requestData['employment_status'])) {
            $requestData['employment_status'] = strtolower($requestData['employment_status']);
        }
        
        if (isset($requestData['work_scope']) && !empty($requestData['work_scope'])) {
            $requestData['work_scope'] = strtolower($requestData['work_scope']);
        }
        
        // Crear un nuevo request con los datos normalizados
        $normalizedRequest = new Request($requestData);
        $normalizedRequest->setMethod($request->method());
        $normalizedRequest->headers->replace($request->headers->all());
        
        $validated = $normalizedRequest->validate([
            'desired_position' => 'nullable|string|max:255',
            'sector_of_interest' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'contract_type_preference' => 'nullable|string|in:tiempo_completo,medio_tiempo,remoto,hibrido',
            'short_term_goals' => 'nullable|string|max:1000',
            'employment_status' => 'required|in:contratado,disponible,en_proceso,discapacitado,fallecido',
            'work_scope' => 'required|in:provincial,nacional',
            'turno' => 'nullable|in:mañana,tarde,noche',
        ], [
            'employment_status.required' => 'El estatus laboral es obligatorio.',
            'employment_status.in' => 'El estatus laboral seleccionado no es válido.',
            'work_scope.required' => 'El alcance laboral es obligatorio.',
            'work_scope.in' => 'El alcance laboral seleccionado no es válido.',
            'expected_salary.numeric' => 'El salario esperado debe ser un número válido.',
            'expected_salary.min' => 'El salario esperado debe ser mayor o igual a 0.',
            'contract_type_preference.in' => 'El tipo de contrato seleccionado no es válido.',
            'turno.in' => 'El turno seleccionado no es válido.',
        ]);

        // Limpiar valores vacíos para campos nullable
        if (empty($validated['contract_type_preference'])) {
            $validated['contract_type_preference'] = null;
        }
        if (empty($validated['turno'])) {
            $validated['turno'] = null;
        }

        try {
            $person->aspiration()->updateOrCreate(
                ['person_id' => $person->id],
                $validated
            );

            return redirect()->route('company.people.show', $person)
                ->with('success', 'Aspiraciones actualizadas correctamente.')
                ->with('activeTab', 'aspirations');
                
        } catch (\Exception $e) {
            \Log::error('Error al actualizar aspiraciones: ' . $e->getMessage());
            
            return redirect()->route('company.people.show', $person)
                ->with('error', 'Error al actualizar las aspiraciones. Por favor, intente nuevamente.')
                ->with('activeTab', 'aspirations');
        }
    }

    /**
     * Update personal information from the show page.
     */
    public function updatePersonalInfo(Request $request, Person $person)
    {
        $request->validate([
            'code_unique' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|max:13|unique:people,dni,' . $person->id,
            'previous_dni' => 'nullable|string|max:13',
            'gender' => 'nullable|in:masculino,femenino,otro',
            'position_applied_for' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:' . implode(',', Person::MARITAL_STATUS_OPTIONS),
            'birth_date' => 'required|date|before:today',
            'age' => 'nullable|integer|min:0|max:120',
            'birth_place' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'cell_phone' => 'required|string|max:13',
            'home_phone' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'social_media_1' => 'nullable|string|max:255',
            'social_media_2' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'medication_allergies' => 'nullable|string|max:500',
            'illnesses' => 'nullable|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:255',
            'other_emergency_contacts' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        $data = $request->except('profile_photo');

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($person->profile_photo && Storage::disk('public')->exists($person->profile_photo)) {
                Storage::disk('public')->delete($person->profile_photo);
            }

            // Store new photo
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $photoPath;
        }

        $person->update($data);

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Información personal actualizada correctamente.')
            ->with('activeTab', 'personal');
    }

    /**
     * Update residence information from the show page.
     */
    public function updateResidenceInfo(Request $request, Person $person)
    {
        $request->validate([
            'regional_id' => 'nullable|exists:regionals,id',
            'province_id' => 'nullable|exists:provinces,id',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'district_id' => 'nullable',
            'sector' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street_and_number' => 'nullable|string|max:500',
            'arrival_reference' => 'nullable|string|max:500',
        ]);

        try {
            // Si no hay municipality_id, no se puede guardar información de residencia
            if (!$request->municipality_id) {
                return redirect()->route('company.people.show', $person)
                    ->with('error', 'Debe seleccionar al menos un municipio.')
                    ->with('activeTab', 'residence');
            }

            // Obtener la información necesaria para guardar
            $data = [
                'municipality_id' => $request->municipality_id,
                'sector' => $request->sector,
                'neighborhood' => $request->neighborhood,
                'street_and_number' => $request->street_and_number,
                'arrival_reference' => $request->arrival_reference,
            ];

            // Obtener province_id del municipality seleccionado
            $municipality = Municipality::with('province')->find($request->municipality_id);
            if ($municipality) {
                $data['province_id'] = $municipality->province_id;
            }

            // Si hay distrito seleccionado, agregarlo
            if ($request->district_id && $request->district_id !== 'no_aplica') {
                $data['district_id'] = $request->district_id;
            }

            // Actualizar o crear la información de residencia
            $person->residenceInformation()->updateOrCreate(
                ['person_id' => $person->id],
                $data
            );

            return redirect()->route('company.people.show', $person)
                ->with('success', 'Información residencial actualizada correctamente.')
                ->with('activeTab', 'residence');
                
        } catch (\Exception $e) {
            \Log::error('Error al actualizar información residencial: ' . $e->getMessage());
            
            return redirect()->route('company.people.show', $person)
                ->with('error', 'Error al actualizar la información residencial. Por favor, intente nuevamente.')
                ->with('activeTab', 'residence');
        }
    }

    /**
     * Get districts by municipality ID for AJAX requests
     */
    public function getDistrictsByMunicipality(Request $request)
    {
        $municipalityId = $request->input('municipality_id');
        
        if (!$municipalityId) {
            return response()->json([]);
        }

        $districts = District::where('municipality_id', $municipalityId)
            ->orderBy('name')
            ->get(['id', 'name']);
            
        return response()->json($districts);
    }

    /**
     * Almacena una nueva habilidad educativa para una persona.
     */
    public function storeEducationalSkill(Request $request, Person $person)
    {
        $validated = $request->validate([
            'career' => 'required|string|max:255',
            'educational_center' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
        ], [
            'career.required' => 'El nombre de la carrera es obligatorio.',
            'educational_center.required' => 'El centro educativo es obligatorio.',
            'year.required' => 'El año de graduación es obligatorio.',
            'year.integer' => 'El año debe ser un número válido.',
            'year.min' => 'El año debe ser mayor a 1900.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 10) . '.',
        ]);

        $person->educationalSkills()->create($validated);

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Habilidad educativa agregada correctamente.')
            ->with('activeTab', 'educational');
    }

    /**
     * Elimina una habilidad educativa.
     */
    public function destroyEducationalSkill(Person $person, EducationalSkill $educationalSkill)
    {
        // Verificar que la habilidad educativa pertenece a la persona
        if ($educationalSkill->person_id !== $person->id) {
            return redirect()->route('company.people.show', $person)
                ->with('error', 'La habilidad educativa no pertenece a esta persona.')
                ->with('activeTab', 'educational');
        }

        $educationalSkill->delete();

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Habilidad educativa eliminada correctamente.')
            ->with('activeTab', 'educational');
    }

    /**
     * Almacena una nueva experiencia laboral para una persona.
     */
    public function storeWorkExperience(Request $request, Person $person)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'year_range' => 'required|string|max:50',
            'achievements' => 'nullable|string|max:2000',
        ], [
            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'position.required' => 'La posición es obligatoria.',
            'year_range.required' => 'El rango de años es obligatorio.',
        ]);

        $person->workExperiences()->create($validated);

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Experiencia laboral agregada correctamente.')
            ->with('activeTab', 'work');
    }

    /**
     * Elimina una experiencia laboral.
     */
    public function destroyWorkExperience(Person $person, WorkExperience $workExperience)
    {
        // Verificar que la experiencia laboral pertenece a la persona
        if ($workExperience->person_id !== $person->id) {
            return redirect()->route('company.people.show', $person)
                ->with('error', 'La experiencia laboral no pertenece a esta persona.')
                ->with('activeTab', 'work');
        }

        $workExperience->delete();

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Experiencia laboral eliminada correctamente.')
            ->with('activeTab', 'work');
    }

    /**
     * Almacena una nueva referencia personal para una persona.
     */
    public function storePersonalReference(Request $request, Person $person)
    {
        $validated = $request->validate([
            'relationship' => 'required|in:padre,madre,conyuge,hermano,tio,amigo,otros',
            'full_name' => 'required|string|max:255',
            'cedula' => ['required', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/'],
            'cell_phone' => ['required', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
        ], [
            'relationship.required' => 'La relación es obligatoria.',
            'relationship.in' => 'La relación seleccionada no es válida.',
            'full_name.required' => 'El nombre completo es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.regex' => 'El formato de la cédula debe ser: 000-0000000-0',
            'cell_phone.required' => 'El teléfono celular es obligatorio.',
            'cell_phone.regex' => 'El formato del teléfono debe ser: 0000-000-0000',
        ]);

        $person->personalReferences()->create($validated);

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Referencia personal agregada correctamente.')
            ->with('activeTab', 'references');
    }

    /**
     * Elimina una referencia personal.
     */
    public function destroyPersonalReference(Person $person, PersonalReference $personalReference)
    {
        // Verificar que la referencia personal pertenece a la persona
        if ($personalReference->person_id !== $person->id) {
            return redirect()->route('company.people.show', $person)
                ->with('error', 'La referencia personal no pertenece a esta persona.')
                ->with('activeTab', 'references');
        }

        $personalReference->delete();

        return redirect()->route('company.people.show', $person)
            ->with('success', 'Referencia personal eliminada correctamente.')
            ->with('activeTab', 'references');
    }
}
