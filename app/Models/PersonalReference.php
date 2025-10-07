<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo PersonalReference
 * 
 * Representa las referencias personales de una persona.
 * Contiene información de contacto de familiares y conocidos.
 */
class PersonalReference extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'relationship',
        'full_name',
        'cedula',
        'cell_phone',
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
     * Los valores permitidos para el tipo de relación.
     *
     * @var array<string>
     */
    public const RELATIONSHIP_OPTIONS = [
        'padre',
        'madre',
        'conyuge',
        'hermano',
        'tio',
        'amigo',
        'otros',
    ];

    /**
     * Relación con la persona.
     * Una referencia personal pertenece a una persona.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Scope para filtrar por tipo de relación.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $relationship
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRelationship($query, string $relationship)
    {
        return $query->where('relationship', $relationship);
    }

    /**
     * Scope para filtrar referencias familiares.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFamily($query)
    {
        return $query->whereIn('relationship', ['padre', 'madre', 'conyuge', 'hermano', 'tio']);
    }

    /**
     * Scope para filtrar referencias no familiares.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonFamily($query)
    {
        return $query->whereIn('relationship', ['amigo', 'otros']);
    }
}

