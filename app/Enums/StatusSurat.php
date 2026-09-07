<?php

namespace App\Enums;

enum StatusSurat: string
{
    case Diajukan = 'Diajukan';
    case Diverifikasi = 'Diverifikasi';
    case Selesai = 'Selesai';
    case Ditolak = 'Ditolak';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
