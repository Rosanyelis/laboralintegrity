<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo EducationalSkill
 * 
 * Representa las habilidades educativas y formación académica de una persona.
 * Contiene información sobre carreras, centros educativos y años de graduación.
 */
class EducationalSkill extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'career',
        'educational_center',
        'province',
        'year',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la persona.
     * Una habilidad educativa pertenece a una persona.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Scope para filtrar por año de graduación.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope para filtrar por rango de años.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $fromYear
     * @param int $toYear
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYearRange($query, int $fromYear, int $toYear)
    {
        return $query->whereBetween('year', [$fromYear, $toYear]);
    }

    /**
     * Scope para filtrar por provincia.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $province
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvince($query, string $province)
    {
        return $query->where('province', $province);
    }

    /**
     * Scope para filtrar por centro educativo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $center
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEducationalCenter($query, string $center)
    {
        return $query->where('educational_center', 'like', "%{$center}%");
    }

    /**
     * Scope para filtrar por carrera.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $career
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCareer($query, string $career)
    {
        return $query->where('career', 'like', "%{$career}%");
    }
}

