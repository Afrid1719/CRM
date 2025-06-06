<?php

namespace App\Support;

use App\Constants\PermissionActions;

class PermissionHelpers
{
    /**
     * Check if the user has a specific permission for a resource.
     *
     * @param int $permission
     * @param string $action
     * @return bool
     */
    public static function hasPermission(int $permission, string $action): bool
    {
        return ($permission & constant(PermissionActions::class . '::' . strtoupper($action))['value']) !== 0;
    }
}
