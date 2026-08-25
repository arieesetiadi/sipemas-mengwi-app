<?php

namespace App\Enums;

enum Role: string
{
    case Perbekel = 'Perbekel';
    case Sekretaris = 'Sekretaris';
    case Staf = 'Staf';
    case Masyarakat = 'Masyarakat';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
