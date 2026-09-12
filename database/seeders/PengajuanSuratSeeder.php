<?php

namespace Database\Seeders;

use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
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

        $dataPerJenis = [
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

        foreach ($dataPerJenis as $kode => $data) {
            $jenisSurat = JenisSurat::where('kode', $kode)->first();

            if (! $jenisSurat) {
                continue;
            }

            PengajuanSurat::updateOrCreate(
                [
                    'penduduk_id' => $penduduk->id,
                    'jenis_surat_id' => $jenisSurat->id,
                ],
                [
                    ...$data,
                    'status' => StatusSurat::Diajukan,
                ]
            );
        }
    }
}
