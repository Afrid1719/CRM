<?php

namespace App\Constants;

class Roles
{
    const ADMIN = 0;
    const USER = 1;
    const GUEST = 2;

    static function all()
    {
        return [
            self::ADMIN => 'Admin',
            self::USER => 'User',
            self::GUEST => 'Guest',
        ];
    }
}
