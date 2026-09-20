<?php

namespace Database\Seeders;

use App\Enums\Agama;
use App\Enums\JenisKelamin;
use App\Enums\Role as RoleEnum;
use App\Enums\StatusPerkawinan;
use App\Models\Admin;
use App\Models\Banjar;
use App\Models\Penduduk;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::updateOrCreate(['label' => $role->value]);
        }

        $banjar = Banjar::firstOrCreate(['label' => 'Banjar Serangan']);

        $accounts = [
            ['Perbekel', 'perbekel@desa.test', RoleEnum::Perbekel],
            ['Sekretaris', 'sekretaris@desa.test', RoleEnum::Sekretaris],
            ['Staf', 'staf@desa.test', RoleEnum::Staf],
        ];

        foreach ($accounts as [$nama, $email, $role]) {
            Admin::updateOrCreate(
                ['email' => $email],
                [
                    'nama' => $nama,
                    'password' => Hash::make(str($nama)->lower()),
                    'role_id' => Role::where('label', $role->value)->value('id'),
                    'is_active' => true,
                ]
            );
        }

        Penduduk::updateOrCreate(
            ['nik' => '0000000000000000'],
            [
                'nama' => 'Penduduk Test',
                'email' => 'penduduk@desa.test',
                'password' => Hash::make('penduduk'),
                'telepon' => '081234567890',
                'alamat' => $banjar->label . ', Desa Mengwi, Kec. Mengwi, Badung',
                'banjar_id' => $banjar->id,
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => JenisKelamin::LakiLaki->value,
                'agama' => Agama::Hindu->value,
                'status_perkawinan' => StatusPerkawinan::Kawin->value,
                'pekerjaan' => 'Wiraswasta',
            ]
        );

        $pendudukDataset = [
            [
                'nik' => '5103010101850001',
                'nama' => 'I Wayan Surya',
                'email' => 'wayan.surya@desa.test',
                'telepon' => '081234567891',
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1985-03-12',
                'jenis_kelamin' => JenisKelamin::LakiLaki->value,
                'status_perkawinan' => StatusPerkawinan::Kawin->value,
                'pekerjaan' => 'Petani',
            ],
            [
                'nik' => '5103010101900002',
                'nama' => 'Ni Made Ayu Lestari',
                'email' => 'made.ayu@desa.test',
                'telepon' => '081234567892',
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1990-07-25',
                'jenis_kelamin' => JenisKelamin::Perempuan->value,
                'status_perkawinan' => StatusPerkawinan::Kawin->value,
                'pekerjaan' => 'Pedagang',
            ],
            [
                'nik' => '5103010101880003',
                'nama' => 'I Gede Putra Wijaya',
                'email' => 'gede.putra@desa.test',
                'telepon' => '081234567893',
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1988-11-02',
                'jenis_kelamin' => JenisKelamin::LakiLaki->value,
                'status_perkawinan' => StatusPerkawinan::BelumKawin->value,
                'pekerjaan' => 'Karyawan Swasta',
            ],
            [
                'nik' => '5103010101920004',
                'nama' => 'Ni Luh Kadek Sari',
                'email' => 'luh.kadek@desa.test',
                'telepon' => '081234567894',
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1992-05-18',
                'jenis_kelamin' => JenisKelamin::Perempuan->value,
                'status_perkawinan' => StatusPerkawinan::Kawin->value,
                'pekerjaan' => 'Guru',
            ],
            [
                'nik' => '5103010101870005',
                'nama' => 'I Ketut Agus Setiawan',
                'email' => 'ketut.agus@desa.test',
                'telepon' => '081234567895',
                'tempat_lahir' => 'Mengwi',
                'tanggal_lahir' => '1987-09-30',
                'jenis_kelamin' => JenisKelamin::LakiLaki->value,
                'status_perkawinan' => StatusPerkawinan::CeraiHidup->value,
                'pekerjaan' => 'Wiraswasta',
            ],
        ];

        foreach ($pendudukDataset as $data) {
            Penduduk::updateOrCreate(
                ['nik' => $data['nik']],
                [
                    ...$data,
                    'password' => Hash::make('penduduk'),
                    'alamat' => $banjar->label . ', Desa Mengwi, Kec. Mengwi, Badung',
                    'banjar_id' => $banjar->id,
                    'agama' => Agama::Hindu->value,
                ]
            );
        }
    }
}
