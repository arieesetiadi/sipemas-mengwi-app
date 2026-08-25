<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Banjar;
use App\Models\Kependudukan;
use App\Models\Role;
use App\Models\User;
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
            ['I Putu Roberto', 'masyarakat@desa.test', RoleEnum::Masyarakat],
        ];

        foreach ($accounts as [$nama, $email, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'nama' => $nama,
                    'password' => Hash::make(str($nama)->lower()),
                    'role_id' => Role::where('label', $role->value)->value('id'),
                    'is_active' => true,
                ]
            );

            if ($role === RoleEnum::Masyarakat) {
                Kependudukan::firstOrCreate(
                    ['nik' => '0000000000000000'],
                    [
                        'user_id' => $user->id,
                        'banjar_id' => $banjar->id,
                        'alamat' => $banjar->label . ', Desa Mengwi, Kec. Mengwi, Badung',
                    ]
                );
            }
        }
    }
}
