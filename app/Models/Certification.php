<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Certification
 * 
 * Representa los tipos de certificaciones disponibles en el sistema.
 */
class Certification extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
     * Relación con los códigos de referencia.
     * Una certificación puede tener múltiples códigos de referencia.
     *
     * @return HasMany
     */
    public function referenceCodes(): HasMany
    {
        return $this->hasMany(ReferenceCode::class);
    }

    /**
     * Scope para filtrar por nombre.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, string $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
}
