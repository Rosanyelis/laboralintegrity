<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\District;
use App\Models\Municipality;
use App\Models\EducationalSkill;
use App\Models\WorkExperience;
use App\Models\PersonalReference;
use App\Models\Aspiration;
use App\Models\ResidenceInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PersonalProfileController extends Controller
{
    /**
     * Dashboard personal del usuario
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->person_id) {
            return redirect()->route('login')
                ->with('error', 'No tienes una persona asociada a tu cuenta.');
        }

        $person = Person::with([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ])->findOrFail($user->person_id);

        return view('user.dashboard', compact('person'));
    }

    /**
     * Mostrar información personal completa
     */
    public function show()
    {
        $user = auth()->user();
        $person = Person::with([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ])->findOrFail($user->person_id);

        Gate::authorize('view', $person);

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

        return view('user.profile.show', compact('person', 'districts', 'municipalities'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit()
    {
        $user = auth()->user();
        $person = Person::with([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ])->findOrFail($user->person_id);

        Gate::authorize('update', $person);

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

        return view('user.profile.edit', compact('person', 'districts', 'municipalities'));
    }

    /**
     * Actualizar información personal
     */
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|max:13|unique:people,dni,' . $person->id,
            'previous_dni' => 'nullable|string|max:13',
            'gender' => 'nullable|in:masculino,femenino,otro',
            'marital_status' => 'nullable|in:' . implode(',', Person::MARITAL_STATUS_OPTIONS),
            'birth_date' => 'required|date|before:today',
            'age' => 'nullable|integer|min:0|max:120',
            'birth_place' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'cell_phone' => 'required|string|max:13',
            'home_phone' => 'nullable|string|max:13',
            'email' => 'required|email|max:255|unique:people,email,' . $person->id,
            'social_media_1' => 'nullable|string|max:255',
            'social_media_2' => 'nullable|string|max:255',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'medication_allergies' => 'nullable|string|max:500',
            'illnesses' => 'nullable|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:13',
            'other_emergency_contacts' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        $data = $request->except('profile_photo');

        // Calcular edad si no se proporcionó
        if (!$data['age'] && $request->birth_date) {
            $birthDate = \Carbon\Carbon::parse($request->birth_date);
            $data['age'] = $birthDate->age;
        }

        // Manejar foto de perfil
        if ($request->hasFile('profile_photo')) {
            if ($person->profile_photo && Storage::disk('public')->exists($person->profile_photo)) {
                Storage::disk('public')->delete($person->profile_photo);
            }
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $photoPath;
        }

        $person->update($data);

        // Actualizar email del usuario si cambió
        if ($person->email !== $user->email) {
            $user->email = $person->email;
            $user->save();
        }

        return redirect()->route('user.profile.show')
            ->with('success', 'Información personal actualizada correctamente.')
            ->with('activeTab', 'personal');
    }

    /**
     * Actualizar información de residencia
     */
    public function updateResidenceInfo(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $request->validate([
            'municipality_id' => 'required|exists:municipalities,id',
            'district_id' => 'nullable',
            'sector' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street_and_number' => 'nullable|string|max:500',
            'arrival_reference' => 'nullable|string|max:500',
        ]);

        try {
            $municipality = Municipality::with('province')->find($request->municipality_id);
            
            $data = [
                'municipality_id' => $request->municipality_id,
                'province_id' => $municipality->province_id,
                'sector' => $request->sector,
                'neighborhood' => $request->neighborhood,
                'street_and_number' => $request->street_and_number,
                'arrival_reference' => $request->arrival_reference,
            ];

            if ($request->district_id && $request->district_id !== 'no_aplica') {
                $data['district_id'] = $request->district_id;
            }

            $person->residenceInformation()->updateOrCreate(
                ['person_id' => $person->id],
                $data
            );

            return redirect()->route('user.profile.show')
                ->with('success', 'Información de residencia actualizada correctamente.')
                ->with('activeTab', 'residence');
                
        } catch (\Exception $e) {
            \Log::error('Error al actualizar información de residencia: ' . $e->getMessage());
            
            return redirect()->route('user.profile.show')
                ->with('error', 'Error al actualizar la información de residencia.')
                ->with('activeTab', 'residence');
        }
    }

    /**
     * Agregar habilidad educativa
     */
    public function storeEducationalSkill(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $validated = $request->validate([
            'career' => 'required|string|max:255',
            'educational_center' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
        ]);

        $person->educationalSkills()->create($validated);

        return redirect()->route('user.profile.show')
            ->with('success', 'Habilidad educativa agregada correctamente.')
            ->with('activeTab', 'educational');
    }

    /**
     * Eliminar habilidad educativa
     */
    public function destroyEducationalSkill(EducationalSkill $educationalSkill)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        if ($educationalSkill->person_id !== $person->id) {
            return redirect()->route('user.profile.show')
                ->with('error', 'La habilidad educativa no pertenece a tu perfil.')
                ->with('activeTab', 'educational');
        }

        $educationalSkill->delete();

        return redirect()->route('user.profile.show')
            ->with('success', 'Habilidad educativa eliminada correctamente.')
            ->with('activeTab', 'educational');
    }

    /**
     * Agregar experiencia laboral
     */
    public function storeWorkExperience(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'year_range' => 'required|string|max:50',
            'achievements' => 'nullable|string|max:2000',
        ]);

        $person->workExperiences()->create($validated);

        return redirect()->route('user.profile.show')
            ->with('success', 'Experiencia laboral agregada correctamente.')
            ->with('activeTab', 'work');
    }

    /**
     * Eliminar experiencia laboral
     */
    public function destroyWorkExperience(WorkExperience $workExperience)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        if ($workExperience->person_id !== $person->id) {
            return redirect()->route('user.profile.show')
                ->with('error', 'La experiencia laboral no pertenece a tu perfil.')
                ->with('activeTab', 'work');
        }

        $workExperience->delete();

        return redirect()->route('user.profile.show')
            ->with('success', 'Experiencia laboral eliminada correctamente.')
            ->with('activeTab', 'work');
    }

    /**
     * Agregar referencia personal
     */
    public function storePersonalReference(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $validated = $request->validate([
            'relationship' => 'required|in:padre,madre,conyuge,hermano,tio,amigo,otros',
            'full_name' => 'required|string|max:255',
            'cedula' => ['required', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/'],
            'cell_phone' => ['required', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
        ]);

        $person->personalReferences()->create($validated);

        return redirect()->route('user.profile.show')
            ->with('success', 'Referencia personal agregada correctamente.')
            ->with('activeTab', 'references');
    }

    /**
     * Eliminar referencia personal
     */
    public function destroyPersonalReference(PersonalReference $personalReference)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        if ($personalReference->person_id !== $person->id) {
            return redirect()->route('user.profile.show')
                ->with('error', 'La referencia personal no pertenece a tu perfil.')
                ->with('activeTab', 'references');
        }

        $personalReference->delete();

        return redirect()->route('user.profile.show')
            ->with('success', 'Referencia personal eliminada correctamente.')
            ->with('activeTab', 'references');
    }

    /**
     * Actualizar aspiraciones
     */
    public function updateAspiration(Request $request)
    {
        $user = auth()->user();
        $person = Person::findOrFail($user->person_id);

        Gate::authorize('update', $person);

        $validated = $request->validate([
            'desired_position' => 'nullable|string|max:255',
            'sector_of_interest' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'contract_type_preference' => 'nullable|in:tiempo_completo,medio_tiempo,remoto,hibrido',
            'short_term_goals' => 'nullable|string|max:1000',
            'employment_status' => 'required|in:contratado,disponible,en_proceso,discapacitado,fallecido',
            'work_scope' => 'required|in:provincial,nacional',
        ]);

        $person->aspiration()->updateOrCreate(
            ['person_id' => $person->id],
            $validated
        );

        return redirect()->route('user.profile.show')
            ->with('success', 'Aspiraciones actualizadas correctamente.')
            ->with('activeTab', 'aspirations');
    }

    /**
     * Generar y descargar CV en PDF
     */
    public function generateCV()
    {
        $user = auth()->user();
        $person = Person::with([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ])->findOrFail($user->person_id);

        Gate::authorize('view', $person);

        $pdf = Pdf::loadView('public.person-registration.cv', compact('person'));
        
        return $pdf->stream('CV_' . $person->code_unique . '_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Obtener distritos por municipio (AJAX)
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
}
