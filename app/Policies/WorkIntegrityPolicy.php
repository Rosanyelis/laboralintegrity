<?php

namespace App\Policies;

use App\Models\WorkIntegrity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WorkIntegrityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('work-integrities.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user?->can('work-integrities.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user?->can('work-integrities.create') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, WorkIntegrity $workIntegrity): bool
    {
        // Solo el usuario que creó la integración o administradores pueden editarla
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('work-integrities.edit') && $user?->id === $workIntegrity->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, WorkIntegrity $workIntegrity): bool
    {
        // Solo Super Administradores pueden eliminar integraciones
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can view actual results.
     */
    public function viewActualResults(?User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user?->can('work-integrities.view-actual-results') ?? false;
    }

    /**
     * Determine whether the user can export work integrity data.
     */
    public function export(?User $user, WorkIntegrity $workIntegrity): bool
    {
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }

    /**
     * Determine whether the user can create work integrity for a specific person.
     */
    public function createForPerson(?User $user, $personId): bool
    {
        if (!$user) {
            return false;
        }

        // Verificar si el usuario puede crear integraciones
        if (!$user->can('work-integrities.create')) {
            return false;
        }

        // Si es administrador, puede crear para cualquier persona
        if ($user->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        // Para usuarios normales, solo pueden crear para personas que ellos crearon
        $person = \App\Models\Person::find($personId);
        return $person && $person->user_id === $user->id;
    }
}