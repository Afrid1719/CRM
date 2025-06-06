<?php

namespace App\Constants;

class PermissionActions
{
    const VIEW = ['name' => 'View', 'value' => 1];
    const CREATE = ['name' => 'Create', 'value' => 2];
    const EDIT = ['name' => 'Edit', 'value' => 4];
    const DELETE = ['name' => 'Delete', 'value' => 8];
}
