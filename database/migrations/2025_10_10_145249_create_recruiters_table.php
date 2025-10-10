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
        Schema::create('recruiters', function (Blueprint $table) {
            $table->id();
            $table->string('code_unique')->unique()->comment('Código único del reclutador formato: XX-DDMMYYYY');
            $table->date('registration_date')->comment('Fecha de registro');
            
            // Relación con empresa (nullable - si no aplica)
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade')->comment('ID de la empresa');
            
            // Relación con persona (representante autorizado - siempre requerido)
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade')->comment('ID del representante autorizado');
            
            $table->string('branch')->nullable()->comment('Sucursal de la empresa');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiters');
    }
};
