<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSuratDataset = [
            ['kode' => 'SKD', 'label' => 'Surat Keterangan Domisili'],
            ['kode' => 'SKU', 'label' => 'Surat Keterangan Usaha'],
            ['kode' => 'SP', 'label' => 'Surat Pengantar'],
        ];

        foreach ($jenisSuratDataset as $jenisSurat) {
            DB::table('jenis_surat')->updateOrInsert(
                ['kode' => $jenisSurat['kode']],
                ['label' => $jenisSurat['label']]
            );
        }
    }
}
