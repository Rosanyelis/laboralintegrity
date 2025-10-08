<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;

class TestPersonCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:person-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la generación automática de códigos únicos para personas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando la generación de códigos únicos...');
        
        // Mostrar estadísticas actuales
        $totalCount = Person::getTotalCount();
        $todayCount = Person::getTodayCount();
        $lastNumber = Person::getLastConsecutiveNumber();
        
        $this->info("Total de personas registradas: {$totalCount}");
        $this->info("Personas registradas hoy: {$todayCount}");
        $this->info("Último número consecutivo de hoy: {$lastNumber}");
        
        // Crear una persona de prueba
        $this->info("\nCreando persona de prueba...");
        
        $person = Person::create([
            'name' => 'Persona Prueba',
            'last_name' => 'Test Code',
            'dni' => '1234567890' . rand(1, 9),
            'country' => 'República Dominicana',
            'birth_place' => 'Santo Domingo',
            'email' => 'test' . time() . '@example.com',
            'birth_date' => '1990-01-01',
            'age' => 34,
        ]);
        
        $this->info("Persona creada con código: {$person->code_unique}");
        
        // Mostrar estadísticas actualizadas
        $newTotalCount = Person::getTotalCount();
        $newTodayCount = Person::getTodayCount();
        $newLastNumber = Person::getLastConsecutiveNumber();
        
        $this->info("\nEstadísticas actualizadas:");
        $this->info("Total de personas registradas: {$newTotalCount}");
        $this->info("Personas registradas hoy: {$newTodayCount}");
        $this->info("Último número consecutivo de hoy: {$newLastNumber}");
        
        $this->info("\n¡Prueba completada exitosamente!");
    }
}
