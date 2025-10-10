<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Regional;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\District;
use App\Models\EducationalSkill;
use App\Http\Requests\Person\StorePersonRequest;
use App\Http\Requests\Person\UpdatePersonRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = Person::orderBy('created_at', 'desc')->paginate(10);
        
        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            
        return view('people.create', compact('districts', 'municipalities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        $validated = $request->validated();

        // Crear la persona
        $person = Person::create($validated);

        // Crear la información de residencia si se proporcionó
        if ($request->filled('district_id') && $request->district_id !== 'no_aplica') {
            $district = District::with(['municipality.province.regional'])->find($request->district_id);
            
            $person->residenceInformation()->create([
                'province_id' => $district->municipality->province->id,
                'municipality_id' => $district->municipality->id,
                'district_id' => $district->id,
                'sector' => $validated['sector'] ?? null,
                'neighborhood' => $validated['neighborhood'] ?? null,
                'street_and_number' => $validated['street_and_number'] ?? null,
                'arrival_reference' => $validated['arrival_reference'] ?? null,
            ]);
        } elseif ($request->filled('municipality_id')) {
            $municipality = Municipality::with(['province.regional'])->find($request->municipality_id);
            
            $person->residenceInformation()->create([
                'province_id' => $municipality->province->id,
                'municipality_id' => $municipality->id,
                'district_id' => null,
                'sector' => $validated['sector'] ?? null,
                'neighborhood' => $validated['neighborhood'] ?? null,
                'street_and_number' => $validated['street_and_number'] ?? null,
                'arrival_reference' => $validated['arrival_reference'] ?? null,
            ]);
        }

        return redirect()->route('people.index')
            ->with('success', 'Persona creada exitosamente.');
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
            'aspirations'
        ]);
        
        // Cargar todos los distritos con sus relaciones para el formulario de residencia
        $districts = District::with(['municipality.province.regional'])
            ->whereHas('municipality', function($query) {
                $query->whereHas('province', function($query) {
                    $query->whereHas('regional');
                });
            })
            ->orderBy('name')
            ->get();
            
        // Cargar municipios para el caso de "No aplica" en distrito
        $municipalities = Municipality::with(['province.regional'])
            ->whereHas('province', function($query) {
                $query->whereHas('regional');
            })
            ->orderBy('name')
            ->get();
        
        return view('people.show', compact('person', 'districts', 'municipalities'));
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
            'cell_phone' => 'required|string|max:12',
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
            if ($person->profile_photo && \Storage::disk('public')->exists($person->profile_photo)) {
                \Storage::disk('public')->delete($person->profile_photo);
            }

            // Store new photo
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $photoPath;
        }

        $person->update($data);

        return redirect()->route('people.show', $person)
            ->with('success', 'Información personal actualizada correctamente.');
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
            return redirect()->route('people.show', $person)
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

            return redirect()->route('people.show', $person)
                ->with('success', 'Información de residencia actualizada correctamente.')
                ->with('activeTab', 'residence');
                
        } catch (\Exception $e) {
            \Log::error('Error al actualizar información de residencia: ' . $e->getMessage());
            
            return redirect()->route('people.show', $person)
                ->with('error', 'Error al actualizar la información de residencia. Por favor, intente nuevamente.')
                ->with('activeTab', 'residence');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        $validated = $request->validated();

        // Actualizar la persona
        $person->update($validated);

        // Actualizar la información de residencia si se proporcionó
        if ($request->filled('district_id') && $request->district_id !== 'no_aplica') {
            $district = District::with(['municipality.province.regional'])->find($request->district_id);
            
            $person->residenceInformation()->updateOrCreate(
                ['person_id' => $person->id],
                [
                    'province_id' => $district->municipality->province->id,
                    'municipality_id' => $district->municipality->id,
                    'district_id' => $district->id,
                    'sector' => $validated['sector'] ?? null,
                    'neighborhood' => $validated['neighborhood'] ?? null,
                    'street_and_number' => $validated['street_and_number'] ?? null,
                    'arrival_reference' => $validated['arrival_reference'] ?? null,
                ]
            );
        } elseif ($request->filled('municipality_id')) {
            $municipality = Municipality::with(['province.regional'])->find($request->municipality_id);
            
            $person->residenceInformation()->updateOrCreate(
                ['person_id' => $person->id],
                [
                    'province_id' => $municipality->province->id,
                    'municipality_id' => $municipality->id,
                    'district_id' => null,
                    'sector' => $validated['sector'] ?? null,
                    'neighborhood' => $validated['neighborhood'] ?? null,
                    'street_and_number' => $validated['street_and_number'] ?? null,
                    'arrival_reference' => $validated['arrival_reference'] ?? null,
                ]
            );
        }

        return redirect()->route('people.index')
            ->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('people.index')
            ->with('success', 'Persona eliminada exitosamente.');
    }

    /**
     * API endpoint para obtener datos de personas para la tabla
     */
    public function api()
    {
        $people = Person::select([
            'id',
            'name',
            'last_name',
            'dni',
            'age',
            'verification_status',
            'employment_status',
            'created_at'
        ])->get();

        return response()->json($people);
    }

    /**
     * Obtener estadísticas de personas registradas
     */
    public function statistics()
    {
        $totalCount = Person::getTotalCount();
        $todayCount = Person::getTodayCount();
        $lastConsecutiveNumber = Person::getLastConsecutiveNumber();
        
        return response()->json([
            'total_count' => $totalCount,
            'today_count' => $todayCount,
            'last_consecutive_number' => $lastConsecutiveNumber,
            'next_code' => str_pad($lastConsecutiveNumber + 1, 2, '0', STR_PAD_LEFT) . '-' . now()->format('dmY')
        ]);
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

        return redirect()->route('people.show', $person)
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
            return redirect()->route('people.show', $person)
                ->with('error', 'La habilidad educativa no pertenece a esta persona.')
                ->with('activeTab', 'educational');
        }

        $educationalSkill->delete();

        return redirect()->route('people.show', $person)
            ->with('success', 'Habilidad educativa eliminada correctamente.')
            ->with('activeTab', 'educational');
    }
}
