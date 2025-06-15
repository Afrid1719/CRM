<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Client;
use App\Models\User;
use App\Support\PermissionHelpers;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $currentuser): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'view', 'Clients');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $currentuser, Client $client): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'view', 'Clients');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $currentuser): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'create', 'Clients');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $currentuser, Client $client): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'edit', 'Clients');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $currentuser, Client $client): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'delete', 'Clients');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $currentuser, Client $client): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'restore', 'Clients');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $currentuser, Client $client): bool
    {
        return $currentuser->isAdmin() || PermissionHelpers::hasPermission($currentuser, 'forceDelete', 'Clients');
    }
}
