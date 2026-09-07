<?php

namespace App\Enums;

enum Agama: string
{
    case Islam = 'Islam';
    case Kristen = 'Kristen';
    case Katolik = 'Katolik';
    case Hindu = 'Hindu';
    case Buddha = 'Buddha';
    case Konghucu = 'Konghucu';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
