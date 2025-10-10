<?php

namespace App\Observers;

use App\Models\Person;

class PersonObserver
{
    /**
     * Handle the Person "creating" event.
     */
    public function creating(Person $person): void
    {
        // Generar código único solo si no se proporciona uno
        if (empty($person->code_unique)) {
            $person->code_unique = $this->generateUniqueCode();
        }
    }

    /**
     * Handle the Person "created" event.
     */
    public function created(Person $person): void
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
        $lastPerson = Person::orderBy('id', 'desc')->first();
        
        if ($lastPerson && $lastPerson->code_unique) {
            // Extraer el número del código existente (antes del guión)
            $parts = explode('-', $lastPerson->code_unique);
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
     * Handle the Person "updated" event.
     */
    public function updated(Person $person): void
    {
        //
    }

    /**
     * Handle the Person "deleted" event.
     */
    public function deleted(Person $person): void
    {
        //
    }

    /**
     * Handle the Person "restored" event.
     */
    public function restored(Person $person): void
    {
        //
    }

    /**
     * Handle the Person "force deleted" event.
     */
    public function forceDeleted(Person $person): void
    {
        //
    }
}
