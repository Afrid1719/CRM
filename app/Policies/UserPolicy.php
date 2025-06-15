<?php

namespace App\Policies;

use App\Support\PermissionHelpers;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view all the model on index page.
     */
    public function viewAny(User $currentUser): bool
    {
        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($currentUser, 'view', 'Users');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $currentUser): bool
    {
        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($currentUser, 'create', 'Users');
    }

    /**
     * Determine whether the user can edit models.
     */
    public function edit(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($currentUser, 'edit', 'Users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($currentUser, 'edit', 'Users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($currentUser, 'delete', 'Users');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin();
    }
}
