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

    public function label(): string
    {
        return match ($this) {
            self::KTP => 'KTP',
            self::KK => 'Kartu Keluarga (KK)',
        };
    }

    public function kolom(): string
    {
        return match ($this) {
            self::KTP => 'ktp_path',
            self::KK => 'kk_path',
        };
    }
}
