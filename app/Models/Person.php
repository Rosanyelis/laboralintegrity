<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo Person
 * 
 * Representa la información personal de los usuarios del sistema.
 * Contiene datos demográficos, contacto, estado civil y información médica.
 */
class Person extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'code_unique',
        'profile_photo',
        'name',
        'last_name',
        'dni',
        'previous_dni',
        'country',
        'zip_code',
        'birth_place',
        'cell_phone',
        'home_phone',
        'email',
        'birth_date',
        'age',
        'marital_status',
        'social_media_1',
        'social_media_2',
        'blood_type',
        'medication_allergies',
        'illnesses',
        'emergency_contact_name',
        'emergency_contact_phone',
        'other_emergency_contacts',
        'position_applied_for',
        'company_code',
        'company_name',
        'verification_status',
        'employment_status',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'age' => 'integer',
        'is_certified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Los valores permitidos para el estado civil.
     *
     * @var array<string>
     */
    public const MARITAL_STATUS_OPTIONS = [
        'soltero',
        'casado',
        'viudo',
    ];

    /**
     * Los valores permitidos para el estado de verificación.
     *
     * @var array<string>
     */
    public const VERIFICATION_STATUS_OPTIONS = [
        'pendiente',
        'parcial',
        'no_aplica',
        'certificado',
    ];

    /**
     * Los valores permitidos para el estado de empleo.
     *
     * @var array<string>
     */
    public const EMPLOYMENT_STATUS_OPTIONS = [
        'pendiente',
        'disponible',
        'en_proceso',
        'contratado',
        'part_time',
        'despido',
        'desaucio',
        'renuncia',
        'aplica',
        'no_aplica',
    ];

    /**
     * Relación con el usuario.
     * Una persona puede estar asociada a un usuario.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la información de residencia.
     * Una persona tiene una información de residencia.
     *
     * @return HasOne
     */
    public function residenceInformation(): HasOne
    {
        return $this->hasOne(ResidenceInformation::class);
    }

    /**
     * Relación con las referencias personales.
     * Una persona puede tener múltiples referencias personales.
     *
     * @return HasMany
     */
    public function personalReferences(): HasMany
    {
        return $this->hasMany(PersonalReference::class);
    }

    /**
     * Relación con las habilidades educativas.
     * Una persona puede tener múltiples habilidades educativas.
     *
     * @return HasMany
     */
    public function educationalSkills(): HasMany
    {
        return $this->hasMany(EducationalSkill::class);
    }

    /**
     * Relación con las experiencias laborales.
     * Una persona puede tener múltiples experiencias laborales.
     *
     * @return HasMany
     */
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Relación con las aspiraciones.
     * Una persona puede tener múltiples aspiraciones.
     *
     * @return HasMany
     */
    public function aspirations(): HasMany
    {
        return $this->hasMany(Aspiration::class);
    }

    /**
     * Obtiene el nombre completo de la persona.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->last_name);
    }

    /**
     * Scope para filtrar por estado de verificación.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerificationStatus($query, string $status)
    {
        return $query->where('verification_status', $status);
    }

    /**
     * Scope para filtrar por estado de empleo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmploymentStatus($query, string $status)
    {
        return $query->where('employment_status', $status);
    }
}

