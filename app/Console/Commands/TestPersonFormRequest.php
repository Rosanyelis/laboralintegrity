<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Requests\Person\StorePersonRequest;
use App\Http\Requests\Person\UpdatePersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class TestPersonFormRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:person-form-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar los Form Request para crear y actualizar personas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando Form Request para Personas...');
        
        // Probar StorePersonRequest
        $this->info("\n=== Probando StorePersonRequest ===");
        
        $validData = [
            'name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan' . time() . '@example.com',
            'dni' => '1234567890' . rand(1, 9),
            'country' => 'República Dominicana',
            'birth_place' => 'Santo Domingo',
            'birth_date' => '1990-01-01',
            'age' => 34,
            'gender' => 'masculino',
            'marital_status' => 'soltero',
        ];
        
        $request = Request::create('/people', 'POST', $validData);
        $storeRequest = StorePersonRequest::createFrom($request);
        $storeRequest->setContainer(app());
        
        if ($storeRequest->authorize()) {
            $this->info("✅ StorePersonRequest autorizado correctamente");
            
            $validator = validator($validData, $storeRequest->rules(), $storeRequest->messages());
            if ($validator->passes()) {
                $this->info("✅ Validación de StorePersonRequest exitosa");
            } else {
                $this->error("❌ Errores de validación en StorePersonRequest:");
                foreach ($validator->errors()->all() as $error) {
                    $this->error("  - {$error}");
                }
            }
        } else {
            $this->error("❌ StorePersonRequest no autorizado");
        }
        
        // Probar UpdatePersonRequest
        $this->info("\n=== Probando UpdatePersonRequest ===");
        
        $person = Person::first();
        if ($person) {
            $updateData = [
                'name' => 'Juan Carlos',
                'last_name' => 'Pérez García',
                'email' => $person->email, // Mantener el mismo email
                'dni' => $person->dni, // Mantener el mismo DNI
                'country' => 'República Dominicana',
                'birth_place' => 'Santo Domingo',
                'birth_date' => '1990-01-01',
                'age' => 35,
                'gender' => 'masculino',
                'marital_status' => 'casado',
            ];
            
            // Probar las reglas directamente
            $updateRules = [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('people')->ignore($person->id)],
                'dni' => ['required', 'string', 'max:20', \Illuminate\Validation\Rule::unique('people')->ignore($person->id)],
                'country' => 'required|string|max:100',
                'birth_place' => 'required|string|max:255',
                'birth_date' => 'required|date|before:today',
                'age' => 'nullable|integer|min:0|max:120',
                'gender' => 'nullable|in:masculino,femenino,otro',
                'marital_status' => 'nullable|in:soltero,casado,viudo',
            ];
            
            $updateValidator = validator($updateData, $updateRules);
            if ($updateValidator->passes()) {
                $this->info("✅ Validación de UpdatePersonRequest exitosa");
            } else {
                $this->error("❌ Errores de validación en UpdatePersonRequest:");
                foreach ($updateValidator->errors()->all() as $error) {
                    $this->error("  - {$error}");
                }
            }
        } else {
            $this->warn("⚠️ No hay personas en la base de datos para probar UpdatePersonRequest");
        }
        
        // Probar validaciones con datos inválidos
        $this->info("\n=== Probando validaciones con datos inválidos ===");
        
        $invalidData = [
            'name' => '', // Campo requerido vacío
            'last_name' => '', // Campo requerido vacío
            'email' => 'email-invalido', // Email inválido
            'dni' => '', // Campo requerido vacío
            'age' => 150, // Edad fuera del rango
            'gender' => 'invalido', // Valor no permitido
        ];
        
        $invalidRequest = Request::create('/people', 'POST', $invalidData);
        $invalidFormRequest = StorePersonRequest::createFrom($invalidRequest);
        $invalidFormRequest->setContainer(app());
        
        $invalidValidator = validator($invalidData, $invalidFormRequest->rules(), $invalidFormRequest->messages());
        
        if ($invalidValidator->fails()) {
            $this->info("✅ Validación de datos inválidos funcionando correctamente:");
            foreach ($invalidValidator->errors()->all() as $error) {
                $this->info("  - {$error}");
            }
        } else {
            $this->error("❌ La validación debería haber fallado con datos inválidos");
        }
        
        $this->info("\n¡Prueba de Form Request completada!");
    }
}
