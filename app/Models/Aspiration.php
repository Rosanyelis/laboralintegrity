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
        'desired_position',
        'sector_of_interest',
        'expected_salary',
        'contract_type_preference',
        'short_term_goals',
        'employment_status',
        'work_scope',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expected_salary' => 'decimal:2',
        'contract_type_preference' => 'array',
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
     * Scope para filtrar por puesto deseado.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $position
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDesiredPosition($query, string $position)
    {
        return $query->where('desired_position', 'like', "%{$position}%");
    }

    /**
     * Scope para filtrar por sector de interés.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sector
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSectorOfInterest($query, string $sector)
    {
        return $query->where('sector_of_interest', 'like', "%{$sector}%");
    }

    /**
     * Scope para filtrar por estatus laboral.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmploymentStatus($query, string $status)
    {
        return $query->where('employment_status', $status);
    }

    /**
     * Scope para filtrar por alcance laboral.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $scope
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWorkScope($query, string $scope)
    {
        return $query->where('work_scope', $scope);
    }

    /**
     * Scope para filtrar aspiraciones disponibles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('employment_status', 'disponible');
    }

    /**
     * Scope para filtrar aspiraciones contratadas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHired($query)
    {
        return $query->where('employment_status', 'contratado');
    }
}

