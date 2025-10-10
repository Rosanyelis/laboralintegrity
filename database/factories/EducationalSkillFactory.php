<?php

namespace Database\Factories;

use App\Models\EducationalSkill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalSkill>
 */
class EducationalSkillFactory extends Factory
{
    protected $model = EducationalSkill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $careers = [
            'Bachiller en Ciencias', 'Bachiller en Letras', 'Técnico en Informática', 'Técnico en Contabilidad',
            'Técnico en Enfermería', 'Técnico en Sistemas', 'Técnico en Refrigeración', 'Técnico en Electricidad',
            'Licenciatura en Administración', 'Ingeniería de Sistemas', 'Contabilidad', 'Mercadeo', 'Derecho',
            'Licenciatura en Educación', 'Enfermería', 'Psicología', 'Arquitectura',
            'Maestría en Administración', 'Maestría en Finanzas', 'MBA', 'Maestría en Educación',
        ];

        $institutions = [
            'UASD', 'PUCMM', 'UNPHU', 'INTEC', 'UTESA', 'UNAPEC', 'O&M', 'UNIBE',
            'INFOTEP', 'ITLA', 'Instituto Técnico Superior',
            'Liceo Juan Pablo Duarte', 'Colegio Santa Ana', 'Politécnico Central',
        ];

        return [
            'career' => fake()->randomElement($careers),
            'educational_center' => fake()->randomElement($institutions),
            'year' => fake()->numberBetween(2000, 2024),
        ];
    }
}
