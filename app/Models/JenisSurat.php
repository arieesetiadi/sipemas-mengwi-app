<?php

namespace App\Models;

use App\Enums\StatusSurat;
use App\Models\PengajuanSurat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $guarded = [];

    public function pengajuanSurat(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public static function rekapSelesai(int $tahun, int $bulan): Collection
    {
        $selesai = PengajuanSurat::query()
            ->where('status', StatusSurat::Selesai)
            ->whereYear('disetujui_pada', $tahun)
            ->whereMonth('disetujui_pada', $bulan)
            ->get();

        $counts = $selesai->countBy(fn (PengajuanSurat $item) => $item->jenis_surat_id);
        $total = $selesai->count();

        return self::orderBy('label')->get()
            ->map(fn (JenisSurat $jenis) => [
                'jenis' => $jenis->label,
                'jumlah' => $jumlah = $counts->get($jenis->id, 0),
                'persentase' => $total > 0 ? round($jumlah / $total * 100, 1) : 0,
            ]);
    }

    public static function rekapSelesaiTahunan(int $tahun): Collection
    {
        $selesai = PengajuanSurat::query()
            ->where('status', StatusSurat::Selesai)
            ->whereYear('disetujui_pada', $tahun)
            ->get();

        $jumlah = [];

        foreach ($selesai as $item) {
            $bulan = $item->disetujui_pada?->month;

            if (! $bulan) {
                continue;
            }

            $jumlah[$item->jenis_surat_id][$bulan] = ($jumlah[$item->jenis_surat_id][$bulan] ?? 0) + 1;
        }

        return self::orderBy('label')->get()
            ->map(fn (JenisSurat $jenis) => [
                'jenis' => $jenis->label,
                'data' => array_map(fn (int $bulan) => $jumlah[$jenis->id][$bulan] ?? 0, range(1, 12)),
            ]);
    }
}
