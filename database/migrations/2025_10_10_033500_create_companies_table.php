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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code_unique')->unique()->comment('Código único para la empresa (formato: 01-08092025)');
            $table->date('registration_date')->comment('Fecha de registro');
            $table->string('business_name')->comment('Nombre de la empresa');
            $table->string('branch')->nullable()->comment('Sucursal');
            $table->string('rnc')->nullable()->comment('RNC');
            $table->string('industry')->nullable()->comment('Rubro/Industria');
            
            // Relaciones geográficas
            $table->foreignId('regional_id')->nullable()->constrained('regionals')->onDelete('set null')->comment('ID de la regional');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('set null')->comment('ID de la provincia');
            $table->foreignId('municipality_id')->nullable()->constrained('municipalities')->onDelete('set null')->comment('ID del municipio');
            $table->string('sector')->nullable()->comment('Sector/dirección');
            
            // Datos de contacto
            $table->string('landline_phone')->nullable()->comment('Teléfono fijo');
            $table->string('extension')->nullable()->comment('Extensión telefónica');
            $table->string('email')->nullable()->comment('Correo electrónico');
            
            // Datos del representante autorizado
            $table->string('representative_name')->nullable()->comment('Nombre y apellidos del representante');
            $table->string('representative_dni')->nullable()->comment('Cédula del representante');
            $table->string('representative_mobile')->nullable()->comment('Teléfono móvil del representante');
            $table->string('representative_email')->nullable()->comment('Correo electrónico personal del representante');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
