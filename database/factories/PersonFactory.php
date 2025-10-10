<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    protected $model = Person::class;

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
            'Jorge', 'Silvia', 'Alberto', 'Claudia', 'Víctor', 'Yolanda', 'Sergio', 'Raquel',
            'Daniel', 'Margarita', 'Alejandro', 'Sandra', 'Eduardo', 'Verónica', 'Ricardo',
            'Mónica', 'Andrés', 'Cristina', 'Javier', 'Beatriz', 'Oscar', 'Adriana', 'Julio',
            'Gabriela', 'Hector', 'Natalia', 'Arturo', 'Susana', 'Enrique', 'Julia', 'Guillermo',
        ];

        $lastNames = [
            'García', 'Rodríguez', 'Martínez', 'Fernández', 'López', 'González', 'Pérez', 'Sánchez',
            'Ramírez', 'Torres', 'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales', 'Reyes',
            'Jiménez', 'Hernández', 'Castillo', 'Vargas', 'Ramos', 'Méndez', 'Castro', 'Ortiz',
            'Ruiz', 'Vega', 'Delgado', 'Campos', 'Santos', 'Medina', 'Peña', 'Guzmán', 'Rojas',
            'Cabrera', 'Valdez', 'Núñez', 'Aguilar', 'Mejía', 'Santana', 'Herrera', 'Contreras',
        ];

        $birthPlaces = [
            'Santo Domingo', 'Santiago', 'La Vega', 'San Cristóbal', 'Puerto Plata', 'San Pedro de Macorís',
            'La Romana', 'Higüey', 'Moca', 'Baní', 'Bonao', 'Azua', 'Barahona', 'Monte Cristi',
            'San Francisco de Macorís', 'Cotuí', 'Mao', 'Nagua', 'San Juan de la Maguana',
        ];

        $positions = [
            'Asistente Administrativo', 'Contador', 'Vendedor', 'Supervisor', 'Gerente',
            'Recepcionista', 'Técnico', 'Analista', 'Coordinador', 'Ejecutivo de Ventas',
            'Auxiliar Contable', 'Desarrollador', 'Diseñador Gráfico', 'Recursos Humanos',
            'Operador', 'Almacenista', 'Chofer', 'Mensajero', 'Secretaria', 'Auxiliar',
        ];

        $companies = [
            'Banco Popular', 'Banco BHD León', 'Banco Reservas', 'Claro Dominicana', 'Altice',
            'Grupo Ramos', 'Grupo Rica', 'Cervecería Nacional Dominicana', 'Induveca', 'Quirch',
            'CCN', 'Supercentro Nacional', 'La Sirena', 'Jumbo', 'PriceSmart', 'Almacenes Unidos',
            'Farmacia Carol', 'Farmacias El Amal', 'Distribuidora Corripio', 'Editora Listin Diario',
        ];

        $gender = fake()->randomElement(['masculino', 'femenino']);
        $birthDate = fake()->dateTimeBetween('-65 years', '-18 years');
        $age = date_diff(date_create($birthDate->format('Y-m-d')), date_create('now'))->y;
        
        // Generar cédula dominicana realista (000-0000000-0)
        $cedula = sprintf(
            '%03d-%07d-%01d',
            fake()->numberBetween(1, 999),
            fake()->numberBetween(1, 9999999),
            fake()->numberBetween(0, 9)
        );

        // Seleccionar ubicación aleatoria
        $province = Province::inRandomOrder()->first();
        $municipality = Municipality::where('province_id', $province->id)->inRandomOrder()->first();
        $district = District::where('municipality_id', $municipality->id)->inRandomOrder()->first();

        return [
            // El code_unique se genera automáticamente por el PersonObserver
            'name' => fake()->randomElement($firstNames),
            'last_name' => fake()->randomElement($lastNames) . ' ' . fake()->randomElement($lastNames),
            'dni' => $cedula,
            'gender' => $gender,
            'country' => 'República Dominicana',
            'zip_code' => fake()->numberBetween(10000, 99999),
            'birth_place' => fake()->randomElement($birthPlaces),
            'cell_phone' => sprintf('%04d-%03d-%04d', 
                fake()->randomElement([8091, 8092, 8093, 8094, 8095, 8096, 8097, 8098, 8099, 8290, 8490, 8590, 8790, 8890, 8990]),
                fake()->numberBetween(100, 999),
                fake()->numberBetween(1000, 9999)
            ),
            'home_phone' => fake()->optional(0.6)->passthrough(sprintf('%03d-%03d-%04d', 
                fake()->randomElement([809, 829, 849]),
                fake()->numberBetween(100, 999),
                fake()->numberBetween(1000, 9999)
            )),
            'email' => fake()->unique()->safeEmail(),
            'birth_date' => $birthDate,
            'age' => $age,
            'marital_status' => fake()->randomElement(['soltero', 'casado', 'viudo']),
            'social_media_1' => fake()->optional(0.7)->passthrough('@' . fake()->userName()),
            'social_media_2' => fake()->optional(0.4)->passthrough('@' . fake()->userName()),
            'blood_type' => fake()->randomElement(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']),
            'medication_allergies' => fake()->optional(0.3)->passthrough(fake()->randomElement([
                'Penicilina', 'Aspirina', 'Ibuprofeno', 'Ninguna', 'Amoxicilina'
            ])),
            'illnesses' => fake()->optional(0.2)->passthrough(fake()->randomElement([
                'Diabetes', 'Hipertensión', 'Asma', 'Ninguna', 'Artritis'
            ])),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => sprintf('%04d-%03d-%04d', 
                fake()->randomElement([8091, 8092, 8093, 8094, 8095]),
                fake()->numberBetween(100, 999),
                fake()->numberBetween(1000, 9999)
            ),
            'position_applied_for' => fake()->randomElement($positions),
            'company_code' => fake()->optional(0.7)->passthrough('C-' . fake()->numberBetween(1000, 9999)),
            'company_name' => fake()->optional(0.7)->passthrough(fake()->randomElement($companies)),
            'verification_status' => fake()->randomElement(['pendiente', 'parcial', 'no_aplica', 'certificado']),
        ];
    }

    /**
     * Estado: Certificado
     */
    public function certified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'certificado',
        ]);
    }

    /**
     * Estado: Pendiente
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'pendiente',
        ]);
    }

    /**
     * Estado: No Aplica
     */
    public function notApplicable(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'no_aplica',
        ]);
    }
}
