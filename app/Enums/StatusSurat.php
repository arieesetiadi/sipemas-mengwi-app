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

    public function badgeClass(): string
    {
        return match ($this) {
            self::Diajukan => 'bg-warning',
            self::Diverifikasi => 'bg-primary',
            self::Selesai => 'bg-success',
            self::Ditolak => 'bg-danger',
        };
    }
}
