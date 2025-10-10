<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo ReferenceCode
 * 
 * Representa los códigos de referencia asociados a las certificaciones.
 */
class ReferenceCode extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'certification_id',
        'code',
        'name',
        'result',
        'description',
        'is_active',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la certificación.
     * Un código de referencia pertenece a una certificación.
     *
     * @return BelongsTo
     */
    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Scope para filtrar códigos activos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para filtrar por tipo de certificación.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $certificationId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCertification($query, int $certificationId)
    {
        return $query->where('certification_id', $certificationId);
    }

    /**
     * Scope para filtrar por código.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCode($query, string $code)
    {
        return $query->where('code', 'like', "%{$code}%");
    }
}
