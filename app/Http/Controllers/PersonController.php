<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Regional;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\District;
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
        
        return view('people.show', compact('person'));
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
}
