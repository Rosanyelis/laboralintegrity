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
        return view('people.show', compact('person'));
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
