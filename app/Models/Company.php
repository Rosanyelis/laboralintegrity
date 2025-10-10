<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo Company
 * 
 * Representa una empresa en el sistema.
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_unique',
        'registration_date',
        'business_name',
        'branch',
        'rnc',
        'industry',
        'regional_id',
        'province_id',
        'municipality_id',
        'sector',
        'landline_phone',
        'extension',
        'email',
        'representative_name',
        'representative_dni',
        'representative_mobile',
        'representative_email',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registration_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relación con la regional.
     * Una empresa pertenece a una regional.
     *
     * @return BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class);
    }

    /**
     * Relación con la provincia.
     * Una empresa pertenece a una provincia.
     *
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Relación con el municipio.
     * Una empresa pertenece a un municipio.
     *
     * @return BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Scope para buscar por nombre de empresa.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBusinessName($query, string $name)
    {
        return $query->where('business_name', 'like', "%{$name}%");
    }

    /**
     * Scope para buscar por RNC.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $rnc
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRnc($query, string $rnc)
    {
        return $query->where('rnc', 'like', "%{$rnc}%");
    }

    /**
     * Scope para buscar por provincia.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $provinceId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvince($query, int $provinceId)
    {
        return $query->where('province_id', $provinceId);
    }

    /**
     * Scope para buscar por municipio.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $municipalityId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMunicipality($query, int $municipalityId)
    {
        return $query->where('municipality_id', $municipalityId);
    }
}
