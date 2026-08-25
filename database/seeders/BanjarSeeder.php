<?php

namespace Database\Seeders;

use App\Models\Banjar;
use Illuminate\Database\Seeder;

class BanjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banjarDataset = [
            'Banjar Alangkajeng',
            'Banjar Bajra',
            'Banjar Batu',
            'Banjar Delod Bale Agung',
            'Banjar Gambang',
            'Banjar Ganter',
            'Banjar Lebah Pangkung',
            'Banjar Munggu',
            'Banjar Pande',
            'Banjar Pandean',
            'Banjar Pengiasan',
            'Banjar Peregae',
            'Banjar Serangan',
        ];

        foreach ($banjarDataset as $banjar) {
            Banjar::updateOrCreate(['label' => $banjar]);
        }
    }
}
