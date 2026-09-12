<?php

namespace App\Http\Controllers\System;

use App\Enums\Role;
use App\Enums\StatusSurat;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\Pengajuan\TolakPengajuanSuratRequest;
use App\Models\JenisSurat;
use App\Models\Lampiran;
use App\Models\PengajuanSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanSurat::with(['penduduk', 'jenisSurat'])->latest()->get();

        $statusCounts = $pengajuan->countBy(fn (PengajuanSurat $item) => $item->status->value);

        $jenisSurat = JenisSurat::orderBy('label')->get();

        return view('system.pages.pengajuan.index', compact('pengajuan', 'statusCounts', 'jenisSurat'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load([
            'penduduk.banjar',
            'jenisSurat',
            'lampiran',
            'diverifikasiOleh',
            'ditolakOleh',
            'disetujuiOleh',
        ]);

        $roleLabel = auth('system')->user()->role?->label;
        $isStaf = $roleLabel === Role::Staf->value;
        $isPimpinan = $this->isPimpinan();

        return view('system.pages.pengajuan.show', compact('pengajuan', 'isStaf', 'isPimpinan'));
    }

    public function verifikasi(PengajuanSurat $pengajuan): RedirectResponse
    {
        if (auth('system')->user()->role?->label !== Role::Staf->value) {
            return back()->with('error', 'Aksi ini hanya untuk Staf.');
        }

        if ($pengajuan->status !== StatusSurat::Diajukan) {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $pengajuan->update([
            'status' => StatusSurat::Diverifikasi,
            'diverifikasi_oleh' => auth('system')->id(),
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil diverifikasi.');
    }

    public function selesai(PengajuanSurat $pengajuan): RedirectResponse
    {
        if (! $this->isPimpinan()) {
            return back()->with('error', 'Aksi ini hanya untuk Sekretaris/Perbekel.');
        }

        if ($pengajuan->status !== StatusSurat::Diverifikasi) {
            return back()->with('error', 'Pengajuan belum bisa diterbitkan.');
        }

        $pengajuan->update([
            'status' => StatusSurat::Selesai,
            'disetujui_oleh' => auth('system')->id(),
            'disetujui_pada' => now(),
            'nomor_surat' => $this->generateNomorSurat($pengajuan),
        ]);

        return back()->with('success', 'Surat berhasil diterbitkan.');
    }

    public function tolak(TolakPengajuanSuratRequest $request, PengajuanSurat $pengajuan): RedirectResponse
    {
        $isStaf = auth('system')->user()->role?->label === Role::Staf->value;
        $isPimpinan = $this->isPimpinan();

        if (! $isStaf && ! $isPimpinan) {
            return back()->with('error', 'Anda tidak punya akses untuk menolak.');
        }

        // staf hanya boleh menolak pengajuan berstatus Diajukan
        if ($isStaf && $pengajuan->status !== StatusSurat::Diajukan) {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        // pimpinan hanya boleh menolak pengajuan berstatus Diverifikasi
        if ($isPimpinan && $pengajuan->status !== StatusSurat::Diverifikasi) {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $pengajuan->update([
            'status' => StatusSurat::Ditolak,
            'catatan_penolakan' => $request->catatan_penolakan,
            'ditolak_oleh' => auth('system')->id(),
            'ditolak_pada' => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }

    public function lampiran(PengajuanSurat $pengajuan, Lampiran $lampiran)
    {
        abort_unless($lampiran->pengajuan_surat_id === $pengajuan->id, 404);
        abort_unless(Storage::disk('local')->exists($lampiran->file_path), 404);

        return response()->file(Storage::disk('local')->path($lampiran->file_path));
    }

    private function isPimpinan(): bool
    {
        return in_array(
            auth('system')->user()->role?->label,
            [Role::Sekretaris->value, Role::Perbekel->value]
        );
    }

    private function generateNomorSurat(PengajuanSurat $pengajuan): string
    {
        $tahun = now()->year;
        $prefix = $pengajuan->jenisSurat->kode . '/' . $tahun . '/';

        // ambil nomor terakhir utk jenis surat & tahun yg sama, lalu +1
        $terakhir = PengajuanSurat::where('jenis_surat_id', $pengajuan->jenis_surat_id)
            ->where('status', StatusSurat::Selesai)
            ->where('nomor_surat', 'like', $prefix . '%')
            ->orderByDesc('nomor_surat')
            ->value('nomor_surat');

        $urutan = $terakhir ? ((int) substr($terakhir, -3)) + 1 : 1;

        return $prefix . str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
    }
}
