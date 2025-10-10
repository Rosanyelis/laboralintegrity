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
        Schema::create('work_integrity_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_integrity_id')->constrained('work_integrities')->onDelete('cascade');
            
            // Tipo de certificación
            $table->foreignId('certification_id')->constrained('certifications')->onDelete('cascade');
            $table->string('certification_name')->comment('Nombre del tipo de certificación');
            
            // Código de referencia
            $table->foreignId('reference_code_id')->constrained('reference_codes')->onDelete('cascade');
            $table->string('reference_code')->comment('Código de referencia');
            $table->string('reference_name')->comment('Nombre del código de referencia');
            
            // Detalle de la evaluación
            $table->text('evaluation_detail')->nullable()->comment('Detalle de la evaluación');
            
            $table->timestamps();
            
            // Índices
            $table->index('work_integrity_id');
            $table->index('certification_id');
            $table->index('reference_code_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_integrity_items');
    }
};
