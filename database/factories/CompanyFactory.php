<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyTypes = [
            'Distribuidora', 'Grupo', 'Corporación', 'Empresa', 'Comercial', 'Almacenes',
            'Supermercados', 'Farmacia', 'Centro', 'Importadora', 'Inversiones', 'Servicios',
        ];

        $companyNames = [
            'Los Pinos', 'El Sol', 'La Estrella', 'San Miguel', 'Santa Rosa', 'Caribe',
            'Dominicana', 'Universal', 'Nacional', 'Central', 'Continental', 'Internacional',
            'Moderna', 'Nueva Era', 'Progreso', 'Desarrollo', 'Innovación', 'Excelencia',
            'Calidad', 'Éxito', 'Victoria', 'Horizonte', 'Futuro', 'Visión',
        ];

        $industries = [
            'Comercio al por mayor y menor',
            'Servicios financieros',
            'Telecomunicaciones',
            'Construcción',
            'Manufactura',
            'Alimentos y bebidas',
            'Servicios profesionales',
            'Educación',
            'Salud',
            'Turismo y hotelería',
            'Transporte y logística',
            'Tecnología',
            'Agroindustria',
            'Farmacéutica',
            'Textil',
            'Importación y exportación',
            'Consultoría',
            'Publicidad y marketing',
        ];

        $sectors = [
            'Zona Colonial', 'Piantini', 'Naco', 'Los Prados', 'Bella Vista', 'Gazcue',
            'La Julia', 'La Esperilla', 'Evaristo Morales', 'Los Cacicazgos', 'Mirador Norte',
            'Villa Mella', 'Los Mina', 'Cristo Rey', 'Villa Juana', 'Ensanche La Fe',
            'Centro de Santiago', 'Los Jardines', 'Gurabo', 'Cienfuegos', 'El Millón',
        ];

        $firstNames = [
            'Juan', 'María', 'Pedro', 'Ana', 'Carlos', 'Rosa', 'José', 'Carmen', 'Luis', 'Luz',
            'Miguel', 'Angela', 'Francisco', 'Elena', 'Rafael', 'Isabel', 'Manuel', 'Teresa',
        ];

        $lastNames = [
            'García', 'Rodríguez', 'Martínez', 'Fernández', 'López', 'González', 'Pérez', 'Sánchez',
            'Ramírez', 'Torres', 'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales',
        ];

        // Generar RNC dominicano realista (9 dígitos)
        $rnc = sprintf('%09d', fake()->unique()->numberBetween(100000000, 999999999));

        // Seleccionar provincia y municipio
        $province = Province::inRandomOrder()->first();
        $municipality = Municipality::where('province_id', $province->id)->inRandomOrder()->first();

        // Generar nombre de empresa
        $businessName = fake()->randomElement($companyTypes) . ' ' . fake()->randomElement($companyNames);
        if (fake()->boolean(30)) {
            $businessName .= ', SRL';
        } elseif (fake()->boolean(20)) {
            $businessName .= ', S.A.';
        }

        // Generar cédula del representante
        $representativeDni = sprintf(
            '%03d-%07d-%01d',
            fake()->numberBetween(1, 999),
            fake()->numberBetween(1, 9999999),
            fake()->numberBetween(0, 9)
        );

        return [
            // El code_unique se genera automáticamente por el CompanyObserver
            'registration_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'business_name' => $businessName,
            'branch' => fake()->optional(0.3)->passthrough(fake()->randomElement([
                'Sucursal Centro', 'Sucursal Norte', 'Sucursal Este', 'Sucursal Oeste',
                'Sucursal Principal', 'Casa Matriz', 'Oficina Central',
            ])),
            'rnc' => $rnc,
            'industry' => fake()->randomElement($industries),
            'regional_id' => $province->regional_id,
            'province_id' => $province->id,
            'municipality_id' => $municipality->id,
            'sector' => fake()->randomElement($sectors),
            'landline_phone' => sprintf('%03d-%03d-%04d', 
                fake()->randomElement([809, 829, 849]),
                fake()->numberBetween(200, 999),
                fake()->numberBetween(1000, 9999)
            ),
            'extension' => fake()->optional(0.5)->passthrough(fake()->numberBetween(100, 999)),
            'email' => strtolower(str_replace([' ', ',', '.'], '', $businessName)) . '@' . fake()->randomElement([
                'gmail.com', 'hotmail.com', 'yahoo.com', 'outlook.com', 'empresa.com.do'
            ]),
            'representative_name' => fake()->randomElement($firstNames) . ' ' . fake()->randomElement($lastNames) . ' ' . fake()->randomElement($lastNames),
            'representative_dni' => $representativeDni,
            'representative_mobile' => sprintf('%04d-%03d-%04d', 
                fake()->randomElement([8091, 8092, 8093, 8094, 8095, 8096, 8097, 8098, 8099]),
                fake()->numberBetween(100, 999),
                fake()->numberBetween(1000, 9999)
            ),
            'representative_email' => fake()->unique()->safeEmail(),
        ];
    }

    /**
     * Estado: Empresa grande con sucursal
     */
    public function withBranch(): static
    {
        return $this->state(fn (array $attributes) => [
            'branch' => fake()->randomElement([
                'Sucursal Centro', 'Sucursal Norte', 'Sucursal Este', 'Sucursal Oeste',
                'Sucursal Principal', 'Casa Matriz',
            ]),
        ]);
    }

    /**
     * Estado: Empresa con extensión telefónica
     */
    public function withExtension(): static
    {
        return $this->state(fn (array $attributes) => [
            'extension' => fake()->numberBetween(100, 999),
        ]);
    }
}
