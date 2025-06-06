<?php

namespace App\Policies;

use App\Support\PermissionHelpers;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can edit models.
     */
    public function edit(User $currentUser, User $model): bool|Response
    {
        $permission = $currentUser->permissions()
            ->where('resource_id', function ($query) {
                $query->select('id')
                    ->from('resources')
                    ->where('name', 'Users');
            })
            ->pluck('value');

        $permission = $permission->first();

        return $currentUser->isAdmin() || PermissionHelpers::hasPermission($permission, 'edit');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $currentUser, User $model): bool
    {
        return $currentUser->isAdmin();
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
