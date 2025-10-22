<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('roles.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Role $role): bool
    {
        return $user?->can('roles.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        // Solo Super Administradores pueden crear roles
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Role $role): bool
    {
        // Solo Super Administradores pueden editar roles
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Role $role): bool
    {
        // Solo Super Administradores pueden eliminar roles
        // Y no se puede eliminar el rol de Super Administrador
        if ($role->name === 'Super Administrador') {
            return false;
        }
        
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Role $role): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Role $role): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can assign permissions to the role.
     */
    public function assignPermissions(?User $user, Role $role): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }
}