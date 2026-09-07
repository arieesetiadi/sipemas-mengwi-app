<?php

namespace App\Enums;

enum StatusPerkawinan: string
{
    case BelumKawin = 'Belum Kawin';
    case Kawin = 'Kawin';
    case CeraiHidup = 'Cerai Hidup';
    case CeraiMati = 'Cerai Mati';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
