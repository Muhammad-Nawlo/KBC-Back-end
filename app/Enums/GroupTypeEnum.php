<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PUBLIC ()
 * @method static self PRIVATE ()
 */
final class GroupTypeEnum extends Enum
{
    protected static function values()
    {
        return [
            "PUBLIC" => 0,
            "PRIVATE" => 1,
        ];
    }
}
