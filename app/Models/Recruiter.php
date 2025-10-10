<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code_unique',
        'registration_date',
        'company_id',
        'person_id',
        'branch',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    /**
     * Relación con la empresa (opcional)
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relación con la persona (representante autorizado)
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
