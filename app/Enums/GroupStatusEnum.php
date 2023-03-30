<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ACTIVE()
 * @method static self BLOCK()
 * @method static self SUSPEND()
 */
final class GroupStatusEnum extends Enum
{
    protected static function values()
    {
        return [
            "ACTIVE" => 0,
            "BLOCK" => 1,
            "SUSPEND" => 2,
        ];
    }
}
