<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
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
            ['Perbekel Test', 'perbekel@desa.test', RoleEnum::Perbekel],
            ['Sekretaris Test', 'sekretaris@desa.test', RoleEnum::Sekretaris],
            ['Staf Test', 'staf@desa.test', RoleEnum::Staf],
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
            ]
        );
    }
}
