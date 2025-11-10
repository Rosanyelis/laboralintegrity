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
use App\Http\Requests\Person\StorePersonRequest;
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
            
        return view('company.people.create', compact('districts', 'municipalities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
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
        $validated = $request->validate([
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
}
