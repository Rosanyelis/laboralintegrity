<?php

namespace App\Policies;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CertificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('certifications.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Certification $certification): bool
    {
        return $user?->can('certifications.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        // Solo administradores pueden crear certificaciones
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Certification $certification): bool
    {
        // Solo administradores pueden editar certificaciones
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Certification $certification): bool
    {
        // Solo Super Administradores pueden eliminar certificaciones
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Certification $certification): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Certification $certification): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }
}