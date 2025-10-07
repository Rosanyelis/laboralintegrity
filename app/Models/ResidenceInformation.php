<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo ResidenceInformation
 * 
 * Representa la información de residencia de una persona.
 * Contiene datos de ubicación geográfica detallada.
 */
class ResidenceInformation extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'province_id',
        'municipality_id',
        'district_id',
        'sector',
        'neighborhood',
        'street_and_number',
        'residential_complex',
        'building',
        'apartment',
        'coordinates',
        'arrival_reference',
        'is_certified',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_certified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la persona.
     * Una información de residencia pertenece a una persona.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Relación con la provincia.
     * Una información de residencia pertenece a una provincia.
     *
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Relación con el municipio.
     * Una información de residencia pertenece a un municipio.
     *
     * @return BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Relación con el distrito.
     * Una información de residencia puede pertenecer a un distrito.
     *
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Obtiene la dirección completa formateada.
     *
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        $addressParts = array_filter([
            $this->street_and_number,
            $this->neighborhood,
            $this->sector,
            $this->residential_complex,
            $this->building,
            $this->apartment,
        ]);

        return implode(', ', $addressParts);
    }

    /**
     * Scope para filtrar por información certificada.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $certified
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCertified($query, bool $certified = true)
    {
        return $query->where('is_certified', $certified);
    }
}

