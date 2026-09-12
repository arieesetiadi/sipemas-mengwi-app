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

    // keterangan buat tooltip di view (null = tanpa tooltip)
    public function keterangan(): ?string
    {
        return match ($this) {
            self::Diajukan => 'Menunggu verifikasi Staf',
            self::Diverifikasi => 'Menunggu persetujuan Sekretaris/Perbekel',
            self::Selesai, self::Ditolak => null,
        };
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
