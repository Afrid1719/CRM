<?php

namespace App\Support;

use App\Constants\PermissionActions;
use App\Models\User;

class PermissionHelpers
{
    /**
     * Check if the user has a specific permission for a resource.
     *
     * @param int $permission
     * @param string $action
     * @return bool
     */
    public static function hasPermission(User $user, string $action, string $resource): bool
    {
        $permission = $user->permissions()
            ->where('resource_id', function ($query) use ($resource) {
                $query->select('id')
                    ->from('resources')
                    ->where('name', $resource);
            })
            ->pluck('value');

        $permission = $permission->first();

        return ($permission & constant(PermissionActions::class . '::' . strtoupper($action))['value']) !== 0;
    }
}
