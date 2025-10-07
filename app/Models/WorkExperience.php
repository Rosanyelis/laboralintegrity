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
        'from_date',
        'to_date',
        'responsibilities',
        'achievements',
        'skills',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
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
     * Obtiene la duración de la experiencia laboral en años.
     *
     * @return float|null
     */
    public function getDurationInYearsAttribute(): ?float
    {
        if (!$this->from_date || !$this->to_date) {
            return null;
        }

        $start = $this->from_date;
        $end = $this->to_date;

        return round($start->diffInDays($end) / 365.25, 2);
    }

    /**
     * Obtiene la duración de la experiencia laboral en meses.
     *
     * @return int|null
     */
    public function getDurationInMonthsAttribute(): ?int
    {
        if (!$this->from_date || !$this->to_date) {
            return null;
        }

        return $this->from_date->diffInMonths($this->to_date);
    }

    /**
     * Verifica si la experiencia laboral está actualmente activa.
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        return $this->to_date === null;
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

    /**
     * Scope para filtrar experiencias actuales.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->whereNull('to_date');
    }

    /**
     * Scope para filtrar experiencias pasadas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        return $query->whereNotNull('to_date');
    }

    /**
     * Scope para filtrar por rango de fechas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $fromDate
     * @param string $toDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, string $fromDate, string $toDate)
    {
        return $query->where(function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('from_date', [$fromDate, $toDate])
              ->orWhereBetween('to_date', [$fromDate, $toDate])
              ->orWhere(function ($subQ) use ($fromDate, $toDate) {
                  $subQ->where('from_date', '<=', $fromDate)
                       ->where(function ($toQ) use ($toDate) {
                           $toQ->whereNull('to_date')
                               ->orWhere('to_date', '>=', $toDate);
                       });
              });
        });
    }
}

