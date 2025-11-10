<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->can('people.index') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Person $person): bool
    {
        // Si el usuario es dueño de la persona (a través de person_id), permitir acceso
        if ($user && $user->person_id === $person->id) {
            return true;
        }
        
        return $user?->can('people.show') ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user?->can('people.create') ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Person $person): bool
    {
        // Si el usuario es dueño de la persona (a través de person_id), permitir acceso
        if ($user && $user->person_id === $person->id) {
            return true;
        }
        
        // Solo el usuario que creó la persona o administradores pueden editarla
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.edit') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Person $person): bool
    {
        // Solo Super Administradores pueden eliminar personas
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Person $person): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Person $person): bool
    {
        return $user?->hasRole('Super Administrador') ?? false;
    }

    /**
     * Determine whether the user can update personal information.
     */
    public function updatePersonalInfo(?User $user, Person $person): bool
    {
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.update-personal-info') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can update residence information.
     */
    public function updateResidenceInfo(?User $user, Person $person): bool
    {
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.update-residence-info') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can manage educational skills.
     */
    public function manageEducationalSkills(?User $user, Person $person): bool
    {
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.manage-educational-skills') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can manage work experiences.
     */
    public function manageWorkExperiences(?User $user, Person $person): bool
    {
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.manage-work-experiences') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can manage personal references.
     */
    public function managePersonalReferences(?User $user, Person $person): bool
    {
        if ($user?->hasRole(['Super Administrador', 'Administrador'])) {
            return true;
        }

        return $user?->can('people.manage-personal-references') && $user?->id === $person->user_id;
    }

    /**
     * Determine whether the user can export person data.
     */
    public function export(?User $user, Person $person): bool
    {
        return $user?->hasRole(['Super Administrador', 'Administrador']) ?? false;
    }
}