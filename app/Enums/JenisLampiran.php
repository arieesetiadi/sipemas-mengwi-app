<?php

namespace App\Enums;

enum JenisLampiran: string
{
    case KTP = 'KTP';
    case KK = 'KK';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
