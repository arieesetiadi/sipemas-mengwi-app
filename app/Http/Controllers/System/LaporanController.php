<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function download(Request $request)
    {
        $data = $this->rekapData($request);

        return Pdf::loadView('system.pages.laporan.rekap-pdf', $data)
            ->download('rekap-laporan-' . $data['periode'] . '.pdf');
    }

    public function cetak(Request $request)
    {
        return view('system.pages.laporan.rekap-print', $this->rekapData($request));
    }

    private function rekapData(Request $request): array
    {
        $periode = $this->resolvePeriode($request->query('bulan'));

        $rekap = JenisSurat::rekapSelesai($periode->year, $periode->month);

        return [
            'rekap' => $rekap,
            'totalRekap' => $rekap->sum('jumlah'),
            'periode' => $periode->format('Y-m'),
            'periodeLabel' => $periode->locale('id')->translatedFormat('F Y'),
        ];
    }

    private function resolvePeriode(?string $bulan): Carbon
    {
        try {
            return filled($bulan)
                ? Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable) {
            return now()->startOfMonth();
        }
    }
}
