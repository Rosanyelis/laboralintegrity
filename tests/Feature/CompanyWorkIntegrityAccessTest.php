<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CompanyWorkIntegrityAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function empresa_sin_pago_no_puede_ver_modulo_depuraciones(): void
    {
        $this->seed(); // asegura permisos/roles base si es necesario

        $company = Company::factory()->create();

        // Crear rol Empresa (si no existe)
        $role = Role::firstOrCreate(['name' => 'Empresa', 'guard_name' => 'web']);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'has_work_integrity_payment' => false,
        ]);
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('company.work-integrities.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function empresa_con_pago_puede_ver_modulo_depuraciones(): void
    {
        $this->seed();

        $company = Company::factory()->create();
        $role = Role::firstOrCreate(['name' => 'Empresa', 'guard_name' => 'web']);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'has_work_integrity_payment' => true,
        ]);
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('company.work-integrities.index'));

        $response->assertStatus(200);
    }
}


