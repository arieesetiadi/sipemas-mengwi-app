<?php

namespace App\Http\Controllers\System;

use App\Enums\Role;
use App\Enums\StatusSurat;
use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $this->resolveTahun($request->query('tahun'));

        $sekarang = now();

        $ringkasan = [
            'butuhTindakan' => PengajuanSurat::query()->butuhTindakan()->count(),
            'selesaiBulanIni' => PengajuanSurat::query()
                ->where('status', StatusSurat::Selesai)
                ->whereYear('disetujui_pada', $sekarang->year)
                ->whereMonth('disetujui_pada', $sekarang->month)
                ->count(),
            'ditolakBulanIni' => PengajuanSurat::query()
                ->where('status', StatusSurat::Ditolak)
                ->whereYear('ditolak_pada', $sekarang->year)
                ->whereMonth('ditolak_pada', $sekarang->month)
                ->count(),
        ];

        $pengajuanTindakan = PengajuanSurat::query()->butuhTindakan()
            ->with(['penduduk', 'jenisSurat'])
            ->latest()
            ->take(5)
            ->get();

        $rekapTahunan = JenisSurat::rekapSelesaiTahunan($tahun);
        $totalRekapTahunan = $rekapTahunan->sum(fn (array $baris) => array_sum($baris['data']));

        $daftarTahun = $this->daftarTahun($tahun);
        $isPerbekel = auth('system')->user()->role?->label === Role::Perbekel->value;

        return view('system.pages.dashboard', compact(
            'ringkasan',
            'pengajuanTindakan',
            'rekapTahunan',
            'totalRekapTahunan',
            'daftarTahun',
            'tahun',
            'isPerbekel',
        ));
    }

    private function resolveTahun(?string $tahun): int
    {
        $tahun = (int) $tahun;

        return $tahun > 0 ? $tahun : now()->year;
    }

    private function daftarTahun(int $tahunTerpilih): Collection
    {
        return PengajuanSurat::query()
            ->whereNotNull('disetujui_pada')
            ->selectRaw('YEAR(disetujui_pada) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->map(fn ($tahun) => (int) $tahun)
            ->push(now()->year, $tahunTerpilih)
            ->unique()
            ->sortDesc()
            ->values();
    }
}
