<?php

namespace App\Http\Controllers\Portal;

use App\Enums\JenisLampiran;
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
        $pengajuan = PengajuanSurat::create([
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

        // simpan lampiran KTP & KK ke disk private
        foreach ([JenisLampiran::KTP => 'lampiran_ktp', JenisLampiran::KK => 'lampiran_kk'] as $jenis => $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('lampiran/' . $pengajuan->id, 'local');

                $pengajuan->lampiran()->create([
                    'jenis_lampiran' => $jenis,
                    'file_path' => $path,
                ]);
            }
        }

        return to_route('portal.home')->with('toast', 'Pengajuan ' . $jenisSurat->label . ' berhasil dikirim.');
    }

    public function download(PengajuanSurat $pengajuan)
    {
        abort_unless($pengajuan->penduduk_id === auth('portal')->id(), 404);

        dd($pengajuan->load(['penduduk', 'jenisSurat', 'lampiran']));
    }
}
