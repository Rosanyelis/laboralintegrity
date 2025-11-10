<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCompanyRegistrationRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompanyRegistrationController extends Controller
{
    /**
     * Mostrar el formulario de registro público de empresas
     */
    public function show()
    {
        $provinces = Province::with('regional')
            ->whereHas('regional')
            ->orderBy('name')
            ->get();
            
        return view('public.company-registration.wizard', compact('provinces'));
    }

    /**
     * Guardar el registro completo de la empresa
     */
    public function store(StoreCompanyRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            // Obtener el regional_id desde la provincia seleccionada
            $province = Province::find($request->province_id);
            
            // Preparar datos de la empresa
            $companyData = [
                'registration_date' => now()->toDateString(),
                'business_name' => $request->business_name,
                'branch' => $request->branch,
                'rnc' => $request->rnc,
                'industry' => $request->industry,
                'regional_id' => $province->regional_id,
                'province_id' => $request->province_id,
                'municipality_id' => $request->municipality_id,
                'sector' => $request->sector,
                'landline_phone' => $request->landline_phone,
                'extension' => $request->extension,
                'email' => $request->email,
                'representative_name' => $request->representative_name,
                'representative_dni' => $request->representative_dni,
                'representative_mobile' => $request->representative_mobile,
                'representative_email' => $request->representative_email,
            ];

            // Crear la empresa (el código único se genera automáticamente por el Observer)
            $company = Company::create($companyData);

            // Crear usuario para la empresa
            $user = User::create([
                'name' => $company->business_name,
                'email' => $request->user_email,
                'password' => Hash::make($request->password),
                'company_id' => $company->id,
            ]);

            // Asignar rol "Empresa"
            $companyRole = Role::firstOrCreate(['name' => 'Empresa']);
            $user->assignRole($companyRole);

            DB::commit();

            // Redirigir al login con mensaje de éxito
            return redirect()->route('login')
                ->with('success', '¡Registro exitoso! Tu empresa ha sido registrada. Por favor inicia sesión con tu correo electrónico y contraseña.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error al registrar empresa: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar tu registro. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Obtener municipios por provincia (AJAX)
     */
    public function getMunicipalitiesByProvince(Request $request)
    {
        $provinceId = $request->input('province_id');
        
        if (!$provinceId) {
            return response()->json([]);
        }

        $municipalities = Municipality::where('province_id', $provinceId)
            ->orderBy('name')
            ->get(['id', 'name']);
            
        return response()->json($municipalities);
    }
}
