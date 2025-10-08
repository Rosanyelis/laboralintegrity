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
        Schema::table('people', function (Blueprint $table) {
            // Hacer nullable los campos que no aparecen en el formulario
            $table->string('code_unique')->nullable()->change();
            $table->string('profile_photo')->nullable()->change();
            $table->string('zip_code')->nullable()->change();
            $table->string('home_phone')->nullable()->change();
            $table->string('social_media_1')->nullable()->change();
            $table->string('social_media_2')->nullable()->change();
            $table->string('other_emergency_contacts')->nullable()->change();
            $table->string('company_code')->nullable()->change();
            $table->string('company_name')->nullable()->change();
            
            // Agregar campos que faltan en el formulario
            $table->enum('gender', ['masculino', 'femenino', 'otro'])->nullable()->after('previous_dni')->comment('Género');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            // Revertir los cambios nullable
            $table->string('code_unique')->nullable(false)->change();
            $table->string('profile_photo')->nullable(false)->change();
            $table->string('zip_code')->nullable(false)->change();
            $table->string('home_phone')->nullable(false)->change();
            $table->string('social_media_1')->nullable(false)->change();
            $table->string('social_media_2')->nullable(false)->change();
            $table->string('other_emergency_contacts')->nullable(false)->change();
            $table->string('company_code')->nullable(false)->change();
            $table->string('company_name')->nullable(false)->change();
            
            // Eliminar el campo gender
            $table->dropColumn('gender');
        });
    }
};
