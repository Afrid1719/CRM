<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Support\PermissionHelpers;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'view', 'Projects');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'view', 'Projects');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'create', 'Projects');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'edit', 'Projects');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'delete', 'Projects');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'restore', 'Projects');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->isAdmin() || PermissionHelpers::hasPermission($user, 'forceDelete', 'Projects');
    }
}
