<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, User $model): bool
    {
        // Solo Super Administradores pueden ver otros usuarios
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        // Solo Super Administradores pueden crear usuarios
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, User $model): bool
    {
        // Solo Super Administradores pueden editar usuarios
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, User $model): bool
    {
        // Solo Super Administradores pueden eliminar usuarios
        // Y no se puede eliminar a sí mismo
        if ($user?->id === $model->id) {
            return false;
        }
        
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, User $model): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, User $model): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can assign roles to the user.
     */
    public function assignRoles(?User $user, User $model): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can change password.
     */
    public function changePassword(?User $user, User $model): bool
    {
        // Solo Super Administradores pueden cambiar contraseñas de otros usuarios
        return $user?->hasRole('Super Administrador') ?? false;
    }
}