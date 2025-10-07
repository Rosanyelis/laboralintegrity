<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Regional
 * 
 * Representa las regiones geográficas del sistema.
 * Cada región puede tener múltiples provincias asociadas.
 */
class Regional extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con las provincias.
     * Una región puede tener múltiples provincias.
     *
     * @return HasMany
     */
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }
}

