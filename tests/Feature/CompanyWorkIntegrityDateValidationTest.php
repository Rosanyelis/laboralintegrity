<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Person;
use App\Models\ReferenceCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CompanyWorkIntegrityDateValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function rechaza_fecha_futura_al_crear_depuracion(): void
    {
        $this->seed();

        $company = Company::factory()->create();
        $role = Role::firstOrCreate(['name' => 'Empresa', 'guard_name' => 'web']);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'has_work_integrity_payment' => true,
        ]);
        $user->assignRole($role);

        $person = Person::factory()->create([
            'company_id' => $company->id,
        ]);

        $reference = ReferenceCode::first(); // proveniente del seeder

        $payload = [
            'fecha' => Carbon::now()->addDay()->toDateString(),
            'person_id' => $person->id,
            'person_dni' => '001-0000000-1',
            'person_name' => 'Juan Pérez',
            'items' => [
                [
                    'reference_code_id' => $reference->id,
                    'reference_code' => $reference->code,
                    'reference_name' => 'Referencia',
                ]
            ],
        ];

        $response = $this->actingAs($user)->post(route('company.work-integrities.store'), $payload);

        $response->assertSessionHasErrors(['fecha']);
    }

    /** @test */
    public function acepta_fecha_hoy_al_crear_depuracion(): void
    {
        $this->seed();

        $company = Company::factory()->create();
        $role = Role::firstOrCreate(['name' => 'Empresa', 'guard_name' => 'web']);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'has_work_integrity_payment' => true,
        ]);
        $user->assignRole($role);

        $person = Person::factory()->create([
            'company_id' => $company->id,
        ]);

        $reference = ReferenceCode::first(); // proveniente del seeder

        $payload = [
            'fecha' => now()->toDateString(),
            'person_id' => $person->id,
            'person_dni' => '001-0000000-2',
            'person_name' => 'María José',
            'items' => [
                [
                    'reference_code_id' => $reference->id,
                    'reference_code' => $reference->code,
                    'reference_name' => 'Referencia',
                ]
            ],
        ];

        $response = $this->actingAs($user)->post(route('company.work-integrities.store'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('company.work-integrities.index'));
    }
}


