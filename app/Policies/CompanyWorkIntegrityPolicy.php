<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkIntegrity;
use Illuminate\Auth\Access\Response;

class CompanyWorkIntegrityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Super Administrador y Administrador siempre tienen acceso
        if ($user->hasRole('Super Administrador') || $user->hasRole('Administrador')) {
            return true;
        }
        
        // Usuarios empresa necesitan tener pago activo
        return $user->company_id !== null && $user->has_work_integrity_payment;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorkIntegrity $workIntegrity): bool
    {
        // Solo puede ver depuraciones de personas de su empresa
        return $user->company_id !== null && 
               $workIntegrity->person && 
               $workIntegrity->person->company_id === $user->company_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Super Administrador y Administrador siempre tienen acceso
        if ($user->hasRole('Super Administrador') || $user->hasRole('Administrador')) {
            return true;
        }
        
        // Usuarios empresa necesitan tener pago activo
        return $user->company_id !== null && $user->has_work_integrity_payment;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorkIntegrity $workIntegrity): bool
    {
        // Solo puede actualizar depuraciones de personas de su empresa
        return $user->company_id !== null && 
               $workIntegrity->person && 
               $workIntegrity->person->company_id === $user->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorkIntegrity $workIntegrity): bool
    {
        // Solo puede eliminar depuraciones de personas de su empresa
        return $user->company_id !== null && 
               $workIntegrity->person && 
               $workIntegrity->person->company_id === $user->company_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user->company_id !== null && 
               $workIntegrity->person && 
               $workIntegrity->person->company_id === $user->company_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorkIntegrity $workIntegrity): bool
    {
        return false;
    }
}
