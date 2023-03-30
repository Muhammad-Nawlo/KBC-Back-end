<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self OWNER()
 * @method static self ADMIN()
 * @method static self MEMBER()
 */
final class GroupPrivilegeEnum extends Enum
{
    protected static function values()
    {
        return [
            "OWNER" => 0,
            "ADMIN" => 1,
            "MEMBER" => 2,
        ];
    }
}
