<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo District
 * 
 * Representa los distritos dentro de un municipio.
 * Cada distrito pertenece a un municipio y puede estar asociado a información de residencia.
 */
class District extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'municipality_id',
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
     * Relación con el municipio.
     * Un distrito pertenece a un municipio.
     *
     * @return BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Relación con la información de residencia.
     * Un distrito puede estar asociado a múltiples registros de residencia.
     *
     * @return HasMany
     */
    public function residenceInformation(): HasMany
    {
        return $this->hasMany(ResidenceInformation::class);
    }
}

