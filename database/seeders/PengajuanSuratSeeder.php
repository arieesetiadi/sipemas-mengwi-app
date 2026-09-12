<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
use App\Models\Admin;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use Illuminate\Database\Seeder;

class PengajuanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penduduk = Penduduk::where('nik', '0000000000000000')->first();

        if (! $penduduk) {
            return;
        }

        $staf = Admin::whereRelation('role', 'label', Role::Staf->value)->first();
        $pimpinan = Admin::whereRelation('role', 'label', Role::Sekretaris->value)->first();

        $detailPerJenis = [
            'SKD' => [
                'status_perkawinan' => StatusPerkawinan::Kawin,
            ],
            'SKU' => [
                'nama_usaha' => 'Warung Sembako Berkah',
                'lokasi_usaha' => 'Banjar Serangan, Mengwi',
            ],
            'SP' => [
                'tujuan_instansi' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'keperluan' => 'Pengurusan administrasi kependudukan',
            ],
        ];

        $urutanSelesai = [];

        foreach ($detailPerJenis as $kode => $detail) {
            $jenisSurat = JenisSurat::where('kode', $kode)->first();

            if (! $jenisSurat) {
                continue;
            }

            foreach (StatusSurat::cases() as $status) {
                $sudahDiverifikasi = in_array($status, [StatusSurat::Diverifikasi, StatusSurat::Selesai]);
                $sudahSelesai = $status === StatusSurat::Selesai;
                $ditolak = $status === StatusSurat::Ditolak;

                PengajuanSurat::firstOrCreate(
                    [
                        'penduduk_id' => $penduduk->id,
                        'jenis_surat_id' => $jenisSurat->id,
                        'status' => $status->value,
                    ],
                    [
                        ...$detail,
                        'diverifikasi_oleh' => $sudahDiverifikasi ? $staf?->id : null,
                        'diverifikasi_pada' => $sudahDiverifikasi ? now() : null,
                        'disetujui_oleh' => $sudahSelesai ? $pimpinan?->id : null,
                        'disetujui_pada' => $sudahSelesai ? now() : null,
                        'nomor_surat' => $sudahSelesai ? $this->buatNomorSurat($kode, $urutanSelesai) : null,
                        'catatan_penolakan' => $ditolak ? 'Berkas tidak lengkap, mohon dilengkapi lalu ajukan ulang.' : null,
                        'ditolak_oleh' => $ditolak ? $staf?->id : null,
                        'ditolak_pada' => $ditolak ? now() : null,
                    ]
                );
            }
        }
    }

    // bikin nomor surat format {kode}/{tahun}/{3 digit}, counter per jenis
    private function buatNomorSurat(string $kode, array &$urutan): string
    {
        $urutan[$kode] = ($urutan[$kode] ?? 0) + 1;

        return $kode . '/' . now()->year . '/' . str_pad((string) $urutan[$kode], 3, '0', STR_PAD_LEFT);
    }
}
