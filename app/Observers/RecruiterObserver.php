<?php

namespace App\Observers;

use App\Models\Recruiter;

class RecruiterObserver
{
    /**
     * Handle the Recruiter "creating" event.
     */
    public function creating(Recruiter $recruiter): void
    {
        // Generar código único solo si no se proporciona uno
        if (empty($recruiter->code_unique)) {
            $recruiter->code_unique = $this->generateUniqueCode();
        }
    }

    /**
     * Handle the Recruiter "created" event.
     */
    public function created(Recruiter $recruiter): void
    {
        //
    }

    /**
     * Generar código único con formato: número consecutivo + fecha
     * Ejemplo: 01-11092025, 02-11092025, 03-12092025
     * El número NO se reinicia cada día, sigue la secuencia general
     */
    private function generateUniqueCode(): string
    {
        $today = now()->format('dmY'); // Formato: 11092025
        
        // Obtener el último registro en general (sin filtrar por fecha)
        $lastRecruiter = Recruiter::orderBy('id', 'desc')->first();
        
        if ($lastRecruiter && $lastRecruiter->code_unique) {
            // Extraer el número del código existente (antes del guión)
            $parts = explode('-', $lastRecruiter->code_unique);
            $lastNumber = (int) $parts[0];
            $nextNumber = $lastNumber + 1;
        } else {
            // Si es el primer registro, empezar con 01
            $nextNumber = 1;
        }
        
        // Formatear el número con ceros a la izquierda (01, 02, 03, etc.)
        $formattedNumber = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        
        return $formattedNumber . '-' . $today;
    }

    /**
     * Handle the Recruiter "updated" event.
     */
    public function updated(Recruiter $recruiter): void
    {
        //
    }

    /**
     * Handle the Recruiter "deleted" event.
     */
    public function deleted(Recruiter $recruiter): void
    {
        //
    }

    /**
     * Handle the Recruiter "restored" event.
     */
    public function restored(Recruiter $recruiter): void
    {
        //
    }

    /**
     * Handle the Recruiter "force deleted" event.
     */
    public function forceDeleted(Recruiter $recruiter): void
    {
        //
    }
}
