<?php

namespace App\Http\Controllers\Portal;

use App\Enums\JenisLampiran;
use App\Enums\Role;
use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Pengajuan\StorePengajuanSuratRequest;
use App\Http\Requests\Portal\Pengajuan\UpdatePengajuanSuratRequest;
use App\Mail\PengajuanBaru;
use App\Models\Admin;
use App\Models\JenisSurat;
use App\Models\Lampiran;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    public function create(JenisSurat $jenisSurat)
    {
        return view('portal.pages.pengajuan.form', compact('jenisSurat'));
    }

    public function edit(PengajuanSurat $pengajuan)
    {
        abort_unless($pengajuan->penduduk_id === auth('portal')->id(), 404);

        if ($pengajuan->status !== StatusSurat::Ditolak) {
            return to_route('portal.home')->with('toast', 'Hanya pengajuan yang ditolak yang bisa diajukan ulang.');
        }

        $jenisSurat = $pengajuan->jenisSurat;

        return view('portal.pages.pengajuan.form', compact('jenisSurat', 'pengajuan'));
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

        foreach (['lampiran_ktp' => JenisLampiran::KTP, 'lampiran_kk' => JenisLampiran::KK] as $field => $jenis) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('lampiran/' . $pengajuan->id, 'local');

                $pengajuan->lampiran()->create([
                    'jenis_lampiran' => $jenis,
                    'file_path' => $path,
                ]);
            }
        }

        $this->kirimNotifikasiPengajuanBaru($pengajuan);

        return to_route('portal.home')->with('toast', 'Pengajuan ' . $jenisSurat->label . ' berhasil dikirim.');
    }

    public function update(UpdatePengajuanSuratRequest $request, PengajuanSurat $pengajuan): RedirectResponse
    {
        abort_unless($pengajuan->penduduk_id === auth('portal')->id(), 404);

        if ($pengajuan->status !== StatusSurat::Ditolak) {
            return to_route('portal.home')->with('toast', 'Pengajuan sudah diproses.');
        }

        $pengajuan->update([
            'status' => StatusSurat::Diajukan,
            'status_perkawinan' => $request->filled('status_perkawinan') ? StatusPerkawinan::from($request->status_perkawinan) : null,
            'tujuan_instansi' => $request->filled('tujuan_instansi') ? $request->tujuan_instansi : null,
            'keperluan' => $request->filled('keperluan') ? $request->keperluan : null,
            'nama_usaha' => $request->filled('nama_usaha') ? $request->nama_usaha : null,
            'lokasi_usaha' => $request->filled('lokasi_usaha') ? $request->lokasi_usaha : null,
            'catatan_penolakan' => null,
            'ditolak_oleh' => null,
            'ditolak_pada' => null,
            'diverifikasi_oleh' => null,
            'diverifikasi_pada' => null,
            'disetujui_oleh' => null,
            'disetujui_pada' => null,
            'nomor_surat' => null,
        ]);

        foreach (['lampiran_ktp' => JenisLampiran::KTP, 'lampiran_kk' => JenisLampiran::KK] as $field => $jenis) {
            if (! $request->hasFile($field)) {
                continue;
            }

            foreach ($pengajuan->lampiran()->where('jenis_lampiran', $jenis->value)->get() as $lama) {
                Storage::disk('local')->delete($lama->file_path);
                $lama->delete();
            }

            $path = $request->file($field)->store('lampiran/' . $pengajuan->id, 'local');

            $pengajuan->lampiran()->create([
                'jenis_lampiran' => $jenis,
                'file_path' => $path,
            ]);
        }

        $this->kirimNotifikasiPengajuanBaru($pengajuan);

        return to_route('portal.home')->with('toast', 'Pengajuan berhasil diajukan ulang.');
    }

    public function lampiran(PengajuanSurat $pengajuan, Lampiran $lampiran)
    {
        abort_unless($pengajuan->penduduk_id === auth('portal')->id(), 404);
        abort_unless($lampiran->pengajuan_surat_id === $pengajuan->id, 404);
        abort_unless(Storage::disk('local')->exists($lampiran->file_path), 404);

        return response()->file(Storage::disk('local')->path($lampiran->file_path));
    }

    public function download(PengajuanSurat $pengajuan)
    {
        abort_unless($pengajuan->penduduk_id === auth('portal')->id(), 404);
        abort_unless($pengajuan->status === StatusSurat::Selesai, 404);

        $pengajuan->load(['penduduk.banjar', 'jenisSurat']);

        $view = match ($pengajuan->jenisSurat->kode) {
            'SKD' => 'portal.surat.domisili',
            'SKU' => 'portal.surat.usaha',
            'SP' => 'portal.surat.pengantar',
            default => abort(404),
        };

        $perbekelNama = Admin::whereRelation('role', 'label', Role::Perbekel->value)->value('nama');

        $tanggalSurat = ($pengajuan->disetujui_pada ?? now())->locale('id')->translatedFormat('d F Y');

        return Pdf::loadView($view, [
            'pengajuan' => $pengajuan,
            'perbekelNama' => $perbekelNama,
            'tanggalSurat' => $tanggalSurat,
        ])->stream('surat-' . strtolower($pengajuan->jenisSurat->kode) . '.pdf');
    }

    private function kirimNotifikasiPengajuanBaru(PengajuanSurat $pengajuan): void
    {
        $adminEmails = Admin::query()->active()
            ->whereHas('role', fn ($query) => $query->whereIn('label', [Role::Staf->value, Role::Sekretaris->value]))
            ->pluck('email');

        if ($adminEmails->isEmpty()) {
            return;
        }

        $pengajuan->load(['penduduk', 'jenisSurat']);

        Mail::to($adminEmails)->send(new PengajuanBaru($pengajuan));
    }
}
