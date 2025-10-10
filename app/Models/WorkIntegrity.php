<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkIntegrity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fecha',
        'company_id',
        'company_code',
        'company_name',
        'company_branch',
        'company_phone',
        'company_email',
        'representative_name',
        'representative_phone',
        'representative_email',
        'person_id',
        'person_dni',
        'person_name',
        'previous_dni',
        'birth_date',
        'birth_place',
        'province',
        'municipality',
        'created_by',
    ];

    protected $casts = [
        'fecha' => 'date',
        'birth_date' => 'date',
    ];

    /**
     * Relación con la empresa
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relación con la persona
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Relación con el usuario que creó el registro
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con los items de integridad laboral
     */
    public function items(): HasMany
    {
        return $this->hasMany(WorkIntegrityItem::class);
    }
}
