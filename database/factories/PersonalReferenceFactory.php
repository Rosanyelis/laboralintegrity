<?php

namespace Database\Factories;

use App\Models\PersonalReference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalReference>
 */
class PersonalReferenceFactory extends Factory
{
    protected $model = PersonalReference::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstNames = [
            'Juan', 'María', 'Pedro', 'Ana', 'Carlos', 'Rosa', 'José', 'Carmen', 'Luis', 'Luz',
            'Miguel', 'Angela', 'Francisco', 'Elena', 'Rafael', 'Isabel', 'Manuel', 'Teresa',
            'Antonio', 'Patricia', 'Ramón', 'Laura', 'Fernando', 'Lucía', 'Roberto', 'Diana',
        ];

        $lastNames = [
            'García', 'Rodríguez', 'Martínez', 'Fernández', 'López', 'González', 'Pérez', 'Sánchez',
            'Ramírez', 'Torres', 'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales', 'Reyes',
        ];

        $relationships = ['padre', 'madre', 'conyuge', 'hermano', 'tio', 'amigo', 'otros'];

        // Generar cédula dominicana realista
        $cedula = sprintf(
            '%03d-%07d-%01d',
            fake()->numberBetween(1, 999),
            fake()->numberBetween(1, 9999999),
            fake()->numberBetween(0, 9)
        );

        // Generar teléfono celular dominicano
        $cellPhone = sprintf('%04d-%03d-%04d', 
            fake()->randomElement([8091, 8092, 8093, 8094, 8095, 8096, 8097, 8098, 8099, 8290]),
            fake()->numberBetween(100, 999),
            fake()->numberBetween(1000, 9999)
        );

        return [
            'relationship' => fake()->randomElement($relationships),
            'full_name' => fake()->randomElement($firstNames) . ' ' . fake()->randomElement($lastNames) . ' ' . fake()->randomElement($lastNames),
            'cedula' => $cedula,
            'cell_phone' => $cellPhone,
        ];
    }
}
