<?php

namespace Database\Factories;

use App\Models\Aspiration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aspiration>
 */
class AspirationFactory extends Factory
{
    protected $model = Aspiration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Gerente de Ventas', 'Supervisor de Operaciones', 'Contador Senior', 'Analista de Sistemas',
            'Coordinador de Recursos Humanos', 'Jefe de Almacén', 'Ejecutivo de Cuentas',
            'Asistente Administrativo', 'Técnico Especializado', 'Encargado de Logística',
            'Diseñador Gráfico', 'Desarrollador de Software', 'Especialista en Marketing',
        ];

        $sectors = [
            'Tecnología', 'Finanzas', 'Comercio', 'Educación', 'Salud', 'Construcción',
            'Turismo', 'Manufactura', 'Logística', 'Telecomunicaciones', 'Servicios',
            'Retail', 'Consultoría', 'Agroindustria', 'Farmacéutica',
        ];

        $goals = [
            'Desarrollar habilidades de liderazgo y gestión de equipos',
            'Especializarme en mi área profesional',
            'Obtener una certificación internacional',
            'Crecer profesionalmente dentro de la empresa',
            'Contribuir al crecimiento de la organización',
            'Aplicar mis conocimientos en proyectos importantes',
            'Alcanzar posiciones de mayor responsabilidad',
            'Mejorar mis habilidades técnicas y profesionales',
        ];

        $contractTypes = [
            'tiempo_completo',
            'medio_tiempo',
            'remoto',
            'hibrido',
        ];

        return [
            'desired_position' => fake()->randomElement($positions),
            'sector_of_interest' => fake()->randomElement($sectors),
            'expected_salary' => fake()->randomFloat(2, 25000, 150000),
            'contract_type_preference' => fake()->randomElement($contractTypes),
            'short_term_goals' => fake()->randomElement($goals),
            'employment_status' => fake()->randomElement(['contratado', 'disponible', 'en_proceso']),
            'work_scope' => fake()->randomElement(['provincial', 'nacional']),
        ];
    }

    /**
     * Estado: Disponible
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'employment_status' => 'disponible',
        ]);
    }

    /**
     * Estado: Contratado
     */
    public function hired(): static
    {
        return $this->state(fn (array $attributes) => [
            'employment_status' => 'contratado',
        ]);
    }
}
