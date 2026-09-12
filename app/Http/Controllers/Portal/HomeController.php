<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;

class HomeController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::orderBy('label')->get();

        $pengajuan = PengajuanSurat::with(['jenisSurat', 'ditolakOleh'])
            ->milikPenduduk(auth('portal')->id())
            ->latest()
            ->get();

        $statusCounts = $pengajuan->countBy(fn (PengajuanSurat $item) => $item->status->value);

        return view('portal.pages.home', compact('jenisSurat', 'pengajuan', 'statusCounts'));
    }
}
