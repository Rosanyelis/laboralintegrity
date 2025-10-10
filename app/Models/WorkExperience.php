<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo WorkExperience
 * 
 * Representa las experiencias laborales de una persona.
 * Contiene información sobre empresas, posiciones, fechas y logros.
 */
class WorkExperience extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'company_name',
        'position',
        'year_range',
        'achievements',
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
     * Relación con la persona.
     * Una experiencia laboral pertenece a una persona.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Scope para filtrar por empresa.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $company
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompany($query, string $company)
    {
        return $query->where('company_name', 'like', "%{$company}%");
    }

    /**
     * Scope para filtrar por posición.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $position
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePosition($query, string $position)
    {
        return $query->where('position', 'like', "%{$position}%");
    }
}

