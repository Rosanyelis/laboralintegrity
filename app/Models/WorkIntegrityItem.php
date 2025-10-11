<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkIntegrityItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_integrity_id',
        'certification_id',
        'reference_code_id',
        'reference_code',
        'reference_name',
        'evaluation_detail',
    ];

    /**
     * Relación con WorkIntegrity
     */
    public function workIntegrity(): BelongsTo
    {
        return $this->belongsTo(WorkIntegrity::class);
    }

    /**
     * Relación con el tipo de depuración
     */
    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Relación con ReferenceCode
     */
    public function referenceCode(): BelongsTo
    {
        return $this->belongsTo(ReferenceCode::class);
    }
}
