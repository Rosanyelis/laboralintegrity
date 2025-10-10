<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_integrities', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->comment('Fecha de la evaluación');
            
            // Relación con empresa
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->string('company_code')->nullable()->comment('Código de la empresa');
            $table->string('company_name')->nullable()->comment('Nombre de la empresa');
            $table->string('company_branch')->nullable()->comment('Sucursal');
            $table->string('company_phone')->nullable()->comment('Teléfono de la empresa');
            $table->string('company_email')->nullable()->comment('Correo de la empresa');
            $table->string('representative_name')->nullable()->comment('Nombre del representante');
            $table->string('representative_phone')->nullable()->comment('Teléfono del representante');
            $table->string('representative_email')->nullable()->comment('Correo del representante');
            
            // Relación con persona
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->string('person_dni')->comment('Cédula de la persona');
            $table->string('person_name')->comment('Nombre completo de la persona');
            $table->string('previous_dni')->nullable()->comment('Cédula anterior');
            $table->date('birth_date')->nullable()->comment('Fecha de nacimiento');
            $table->string('birth_place')->nullable()->comment('Lugar de nacimiento');
            
            // Ubicación
            $table->string('province')->nullable()->comment('Provincia');
            $table->string('municipality')->nullable()->comment('Municipio');
            
            // Usuario que registra
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('fecha');
            $table->index('person_dni');
            $table->index('company_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_integrities');
    }
};
