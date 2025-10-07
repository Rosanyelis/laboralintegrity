<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Aspiration
 * 
 * Representa las aspiraciones laborales de una persona.
 * Contiene información sobre ocupación deseada, disponibilidad y horarios.
 */
class Aspiration extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'occupation',
        'availability',
        'hour_range',
        'hours_per_week',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hours_per_week' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la persona.
     * Una aspiración pertenece a una persona.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Scope para filtrar por ocupación.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $occupation
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOccupation($query, string $occupation)
    {
        return $query->where('occupation', 'like', "%{$occupation}%");
    }

    /**
     * Scope para filtrar por disponibilidad.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $availability
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailability($query, string $availability)
    {
        return $query->where('availability', $availability);
    }

    /**
     * Scope para filtrar por rango de horas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $hourRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHourRange($query, string $hourRange)
    {
        return $query->where('hour_range', $hourRange);
    }

    /**
     * Scope para filtrar por horas por semana.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $hours
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHoursPerWeek($query, int $hours)
    {
        return $query->where('hours_per_week', $hours);
    }

    /**
     * Scope para filtrar por rango de horas por semana.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $minHours
     * @param int $maxHours
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHoursPerWeekRange($query, int $minHours, int $maxHours)
    {
        return $query->whereBetween('hours_per_week', [$minHours, $maxHours]);
    }

    /**
     * Scope para filtrar aspiraciones de tiempo completo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFullTime($query)
    {
        return $query->where('hours_per_week', '>=', 40);
    }

    /**
     * Scope para filtrar aspiraciones de medio tiempo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePartTime($query)
    {
        return $query->where('hours_per_week', '<', 40);
    }
}

