<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\ResidenceInformation;
use App\Models\EducationalSkill;
use App\Models\WorkExperience;
use App\Models\PersonalReference;
use App\Models\Aspiration;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando 30 personas con datos de ejemplo...');

        Person::factory()
            ->count(30)
            ->create()
            ->each(function (Person $person) {
                // Crear información de residencia para cada persona
                ResidenceInformation::factory()->create([
                    'person_id' => $person->id,
                ]);

                // Crear 1-3 habilidades educativas
                EducationalSkill::factory()
                    ->count(rand(1, 3))
                    ->create([
                        'person_id' => $person->id,
                    ]);

                // Crear 0-2 experiencias laborales
                WorkExperience::factory()
                    ->count(rand(0, 2))
                    ->create([
                        'person_id' => $person->id,
                    ]);

                // Crear 1-2 referencias personales
                PersonalReference::factory()
                    ->count(rand(1, 2))
                    ->create([
                        'person_id' => $person->id,
                    ]);

                // Crear aspiraciones laborales
                Aspiration::factory()->create([
                    'person_id' => $person->id,
                ]);
            });

        $this->command->info('✓ Se crearon 30 personas con toda su información relacionada.');
    }
}
