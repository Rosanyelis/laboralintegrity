<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "creating" event.
     */
    public function creating(Company $company): void
    {
        // Generar código único solo si no se proporciona uno
        if (empty($company->code_unique)) {
            $company->code_unique = $this->generateUniqueCode();
        }
    }

    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        //
    }

    /**
     * Generar código único con formato: número consecutivo + fecha
     * Ejemplo: 01-11092025
     */
    private function generateUniqueCode(): string
    {
        $today = now()->format('dmY'); // Formato: 11092025
        
        // Obtener el último número consecutivo del día actual
        $lastCompany = Company::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastCompany && $lastCompany->code_unique) {
            // Extraer el número del código existente
            $lastNumber = (int) substr($lastCompany->code_unique, 0, 2);
            $nextNumber = $lastNumber + 1;
        } else {
            // Si es el primer registro del día, empezar con 01
            $nextNumber = 1;
        }
        
        // Formatear el número con ceros a la izquierda (01, 02, 03, etc.)
        $formattedNumber = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        
        return $formattedNumber . '-' . $today;
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
