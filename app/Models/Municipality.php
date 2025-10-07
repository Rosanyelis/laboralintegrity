<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Municipality
 * 
 * Representa los municipios dentro de una provincia.
 * Cada municipio pertenece a una provincia y puede tener múltiples distritos.
 */
class Municipality extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'province_id',
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
     * Relación con la provincia.
     * Un municipio pertenece a una provincia.
     *
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Relación con los distritos.
     * Un municipio puede tener múltiples distritos.
     *
     * @return HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * Relación con la información de residencia.
     * Un municipio puede estar asociado a múltiples registros de residencia.
     *
     * @return HasMany
     */
    public function residenceInformation(): HasMany
    {
        return $this->hasMany(ResidenceInformation::class);
    }
}

