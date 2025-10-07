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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index()->comment('ID del usuario asociado a esta persona');
            $table->string('code_unique')->unique()->comment('Código único para la persona entre numero consecutivo y fecha 01-08092025');
            $table->string('profile_photo')->nullable()->comment('Foto de perfil');
            $table->string('name')->comment('Nombres');
            $table->string('last_name')->comment('Apellidos');
            $table->string('dni')->unique()->comment('Cedula');
            $table->string('previous_dni')->nullable()->comment('Cedula anterior');
            $table->string('country')->comment('País');
            $table->string('zip_code')->nullable()->comment('Código postal');
            $table->string('birth_place')->comment('Lugar de nacimiento');
            $table->string('cell_phone')->nullable()->comment('Teléfono celular');
            $table->string('home_phone')->nullable()->comment('Teléfono fijo');
            $table->string('email')->nullable()->comment('Email');
            $table->date('birth_date')->comment('Fecha de nacimiento');
            $table->integer('age')->nullable()->comment('Edad');
            $table->enum('marital_status', ['soltero', 'casado', 'viudo'])->nullable()->comment('Estado Civil');
            $table->string('social_media_1')->nullable()->comment('Red social 1');
            $table->string('social_media_2')->nullable()->comment('Red social 2');
            $table->string('blood_type')->nullable()->comment('Tipo de sangre');
            $table->text('medication_allergies')->nullable()->comment('Medicamentos y alergias');
            $table->text('illnesses')->nullable()->comment('Enfermedades');
            $table->string('emergency_contact_name')->nullable()->comment('Nombre de contacto de emergencia');
            $table->string('emergency_contact_phone')->nullable()->comment('Teléfono de contacto de emergencia');
            $table->string('other_emergency_contacts')->nullable()->comment('Otros contactos de emergencia');
            $table->string('position_applied_for')->nullable()->comment('Posición aplicada para');
            $table->string('company_code')->nullable()->comment('Código de la empresa');
            $table->string('company_name')->nullable()->comment('Nombre de la empresa');
            $table->enum('verification_status', ['pendiente', 'parcial', 'no_aplica', 'certificado'])->default('pendiente')->comment('Estado de verificación');
            $table->enum('employment_status', ['pendiente', 'disponible', 'en_proceso', 'contratado', 'part_time', 'despido', 'desaucio', 'renuncia', 'aplica', 'no_aplica'])->default('pendiente')->comment('Estado de empleo');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};