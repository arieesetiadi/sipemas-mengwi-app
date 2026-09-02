<?php

namespace App\Http\Controllers\Portal;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('portal.pages.register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'telepon' => $request->filled('telepon') ? $data['telepon'] : null,
            'password' => $data['password'],
            'role_id' => Role::where('label', RoleEnum::Penduduk->value)->value('id'),
            'is_active' => true,
        ]);

        Auth::guard('portal')->login($user);

        return to_route('portal.home')->with('toast', 'Pendaftaran berhasil, selamat datang ' . $user->nama . '!');
    }
}
