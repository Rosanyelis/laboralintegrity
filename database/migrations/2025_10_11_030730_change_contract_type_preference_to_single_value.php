<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero cambiar el tipo de columna de JSON a TEXT
        Schema::table('aspirations', function (Blueprint $table) {
            $table->text('contract_type_preference')->nullable()->change();
        });
        
        // Luego, convertir los datos existentes de array JSON a string
        $aspirations = DB::table('aspirations')->whereNotNull('contract_type_preference')->get();
        
        foreach ($aspirations as $aspiration) {
            $value = $aspiration->contract_type_preference;
            
            // Si es JSON válido, extraer el primer elemento
            $decoded = json_decode($value, true);
            if (is_array($decoded) && !empty($decoded)) {
                $firstValue = $decoded[0];
            } else {
                // Si no es JSON o está vacío, usar el valor tal cual o null
                $firstValue = $value;
            }
            
            DB::table('aspirations')
                ->where('id', $aspiration->id)
                ->update(['contract_type_preference' => $firstValue]);
        }
        
        // Finalmente cambiar a string
        Schema::table('aspirations', function (Blueprint $table) {
            $table->string('contract_type_preference')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            // Volver a JSON
            $table->json('contract_type_preference')->nullable()->change();
        });
    }
};
