<?php

namespace App\Policies;

use App\Models\ReferenceCode;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReferenceCodePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('reference-codes.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, ReferenceCode $referenceCode): bool
    {
        return $user?->can('reference-codes.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        // Solo administradores pueden crear códigos de referencia
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, ReferenceCode $referenceCode): bool
    {
        // Solo administradores pueden editar códigos de referencia
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, ReferenceCode $referenceCode): bool
    {
        // Solo Super Administradores pueden eliminar códigos de referencia
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, ReferenceCode $referenceCode): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, ReferenceCode $referenceCode): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }
}