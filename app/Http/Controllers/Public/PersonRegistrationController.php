<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StorePersonRegistrationRequest;
use App\Models\Person;
use App\Models\User;
use App\Models\District;
use App\Models\Municipality;
use App\Models\EducationalSkill;
use App\Models\WorkExperience;
use App\Models\PersonalReference;
use App\Models\Aspiration;
use App\Models\ResidenceInformation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PersonRegistrationController extends Controller
{
    /**
     * Mostrar el formulario de registro público
     */
    public function show()
    {
        $municipalities = Municipality::with(['province.regional'])
            ->whereHas('province', function($query) {
                $query->whereHas('regional');
            })
            ->orderBy('name')
            ->get();
            
        return view('public.person-registration.wizard', compact('municipalities'));
    }

    /**
     * Guardar el registro completo de la persona
     */
    public function store(StorePersonRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            // Generar código único
            $lastConsecutive = Person::getLastConsecutiveNumber();
            $consecutiveNumber = str_pad($lastConsecutive + 1, 2, '0', STR_PAD_LEFT);
            $codeUnique = $consecutiveNumber . '-' . now()->format('dmY');

            // Calcular edad si no se proporcionó
            $age = $request->age;
            if (!$age && $request->birth_date) {
                $birthDate = \Carbon\Carbon::parse($request->birth_date);
                $age = $birthDate->age;
            }

            // Preparar datos de la persona
            $personData = [
                'code_unique' => $codeUnique,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'dni' => $request->dni,
                'previous_dni' => $request->previous_dni,
                'gender' => $request->gender,
                'country' => $request->country,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'age' => $age,
                'marital_status' => $request->marital_status,
                'email' => $request->email,
                'cell_phone' => $request->cell_phone,
                'home_phone' => $request->home_phone,
                'social_media_1' => $request->social_media_1,
                'social_media_2' => $request->social_media_2,
                'blood_type' => $request->blood_type,
                'medication_allergies' => $request->medication_allergies,
                'illnesses' => $request->illnesses,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'other_emergency_contacts' => $request->other_emergency_contacts,
                'verification_status' => 'pendiente',
            ];

            // Manejar foto de perfil
            if ($request->hasFile('profile_photo')) {
                $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
                $personData['profile_photo'] = $photoPath;
            }

            // Crear la persona
            $person = Person::create($personData);

            // Crear información de residencia
            if ($request->municipality_id) {
                $municipality = Municipality::with('province')->find($request->municipality_id);
                
                $residenceData = [
                    'person_id' => $person->id,
                    'province_id' => $municipality->province_id,
                    'municipality_id' => $request->municipality_id,
                    'sector' => $request->sector,
                    'neighborhood' => $request->neighborhood,
                    'street_and_number' => $request->street_and_number,
                    'arrival_reference' => $request->arrival_reference,
                ];

                // Agregar distrito si se seleccionó y no es "no_aplica"
                if ($request->district_id && $request->district_id !== 'no_aplica') {
                    $residenceData['district_id'] = $request->district_id;
                }

                ResidenceInformation::create($residenceData);
            }

            // Crear habilidades educativas
            if ($request->filled('educational_skills')) {
                foreach ($request->educational_skills as $skill) {
                    EducationalSkill::create([
                        'person_id' => $person->id,
                        'career' => $skill['career'],
                        'educational_center' => $skill['educational_center'],
                        'year' => $skill['year'],
                    ]);
                }
            }

            // Crear experiencias laborales
            if ($request->filled('work_experiences')) {
                foreach ($request->work_experiences as $experience) {
                    WorkExperience::create([
                        'person_id' => $person->id,
                        'company_name' => $experience['company_name'],
                        'position' => $experience['position'],
                        'year_range' => $experience['year_range'],
                        'achievements' => $experience['achievements'] ?? null,
                    ]);
                }
            }

            // Crear referencias personales
            if ($request->filled('personal_references')) {
                foreach ($request->personal_references as $reference) {
                    PersonalReference::create([
                        'person_id' => $person->id,
                        'relationship' => $reference['relationship'],
                        'full_name' => $reference['full_name'],
                        'cedula' => $reference['cedula'],
                        'cell_phone' => $reference['cell_phone'],
                    ]);
                }
            }

            // Crear aspiraciones
            Aspiration::create([
                'person_id' => $person->id,
                'desired_position' => $request->desired_position,
                'sector_of_interest' => $request->sector_of_interest,
                'expected_salary' => $request->expected_salary,
                'contract_type_preference' => $request->contract_type_preference,
                'short_term_goals' => $request->short_term_goals,
                'employment_status' => $request->employment_status,
                'work_scope' => $request->work_scope,
                'turno' => $request->turno,
            ]);

            // Crear usuario
            $user = User::create([
                'name' => $person->name . ' ' . $person->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'person_id' => $person->id,
            ]);

            // Asignar rol "Usuario"
            $userRole = Role::firstOrCreate(['name' => 'Usuario']);
            $user->assignRole($userRole);

            DB::commit();

            // Redirigir al login con mensaje de éxito
            return redirect()->route('login')
                ->with('success', '¡Registro exitoso! Tu cuenta ha sido creada. Por favor inicia sesión con tu correo electrónico y contraseña.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error al registrar persona: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar tu registro. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Generar y descargar el CV en PDF
     */
    public function generateCV(Person $person)
    {
        // Verificar que el usuario autenticado tenga acceso a esta persona
        if (auth()->check() && auth()->user()->person_id !== $person->id && !auth()->user()->hasRole('Super Administrador') && !auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para acceder a este CV.');
        }

        // Cargar todas las relaciones necesarias
        $person->load([
            'residenceInformation.province.regional',
            'residenceInformation.municipality',
            'residenceInformation.district',
            'educationalSkills',
            'workExperiences',
            'personalReferences',
            'aspiration',
        ]);

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

