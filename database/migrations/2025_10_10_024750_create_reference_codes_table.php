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
        Schema::create('reference_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_id')->constrained('certifications')->onDelete('cascade')->comment('Tipo de certificación');
            $table->string('code')->unique()->comment('Código de referencia');
            $table->string('result')->comment('Resultado del código');
            $table->text('description')->nullable()->comment('Descripción adicional');
            $table->boolean('is_active')->default(true)->comment('Estado activo/inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reference_codes');
    }
};
