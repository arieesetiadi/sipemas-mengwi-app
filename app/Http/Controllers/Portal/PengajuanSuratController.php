<?php

namespace App\Http\Controllers\Portal;

use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Pengajuan\StorePengajuanSuratRequest;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\RedirectResponse;

class PengajuanSuratController extends Controller
{
    public function create(JenisSurat $jenisSurat)
    {
        return view('portal.pages.pengajuan.form', compact('jenisSurat'));
    }

    public function store(StorePengajuanSuratRequest $request, JenisSurat $jenisSurat): RedirectResponse
    {
        PengajuanSurat::create([
            'penduduk_id' => auth('portal')->id(),
            'jenis_surat_id' => $jenisSurat->id,
            'status' => StatusSurat::Diajukan,
            'status_perkawinan' => $request->filled('status_perkawinan') ? StatusPerkawinan::from($request->status_perkawinan) : null,
            'tujuan_instansi' => $request->filled('tujuan_instansi') ? $request->tujuan_instansi : null,
            'keperluan' => $request->filled('keperluan') ? $request->keperluan : null,
            'nama_usaha' => $request->filled('nama_usaha') ? $request->nama_usaha : null,
            'lokasi_usaha' => $request->filled('lokasi_usaha') ? $request->lokasi_usaha : null,
            'catatan' => $request->filled('catatan') ? $request->catatan : null,
        ]);

        return to_route('portal.home')->with('toast', 'Pengajuan ' . $jenisSurat->label . ' berhasil dikirim.');
    }
}
