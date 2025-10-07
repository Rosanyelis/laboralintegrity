<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Province
 * 
 * Representa las provincias dentro de una región.
 * Cada provincia pertenece a una región y puede tener múltiples municipios.
 */
class Province extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'regional_id',
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
     * Relación con la región.
     * Una provincia pertenece a una región.
     *
     * @return BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class);
    }

    /**
     * Relación con los municipios.
     * Una provincia puede tener múltiples municipios.
     *
     * @return HasMany
     */
    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }

    /**
     * Relación con la información de residencia.
     * Una provincia puede estar asociada a múltiples registros de residencia.
     *
     * @return HasMany
     */
    public function residenceInformation(): HasMany
    {
        return $this->hasMany(ResidenceInformation::class);
    }
}

