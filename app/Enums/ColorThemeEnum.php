<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self WHITE()
 * @method static self BLACK()
 * @method static self PINK()
 * @method static self BLUE()
 */
final class ColorThemeEnum extends Enum
{
    protected static function values()
    {
        return [
            "WHITE" => 0,
            "BLACK" => 1,
            "PINK" => 2,
            "BLUE" => 3,
        ];
    }
}
