<?php

namespace App\Policies;

use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecruiterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('recruiters.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Recruiter $recruiter): bool
    {
        return $user?->can('recruiters.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user?->can('recruiters.create') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Recruiter $recruiter): bool
    {
        // Solo el usuario que creó el reclutador o administradores pueden editarlo
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('recruiters.edit') && $user?->id === $recruiter->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Recruiter $recruiter): bool
    {
        // Solo Super Administradores pueden eliminar reclutadores
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Recruiter $recruiter): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Recruiter $recruiter): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can search by RNC.
     */
    public function searchByRnc(?User $user): bool
    {
        return $user?->can('recruiters.index') ?? false;
    }

    /**
     * Determine whether the user can search by DNI.
     */
    public function searchByDni(?User $user): bool
    {
        return $user?->can('recruiters.index') ?? false;
    }

    /**
     * Determine whether the user can export recruiter data.
     */
    public function export(?User $user, Recruiter $recruiter): bool
    {
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }
}