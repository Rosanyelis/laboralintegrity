<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('companies.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Company $company): bool
    {
        return $user?->can('companies.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user?->can('companies.create') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Company $company): bool
    {
        // Solo el usuario que creó la empresa o administradores pueden editarla
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('companies.edit') && $user?->id === $company->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Company $company): bool
    {
        // Solo Super Administradores pueden eliminar empresas
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Company $company): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Company $company): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can check RNC.
     */
    public function checkRnc(?User $user): bool
    {
        return $user?->can('companies.check-rnc') ?? false;
    }

    /**
     * Determine whether the user can export company data.
     */
    public function export(?User $user, Company $company): bool
    {
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }
}