<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Auth\RegisterRequest;
use App\Models\Banjar;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        $banjar = Banjar::orderBy('label')->get();

        return view('portal.pages.register', compact('banjar'));
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $penduduk = Penduduk::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'telepon' => $request->filled('telepon') ? $data['telepon'] : null,
            'password' => $data['password'],
            'nik' => $data['nik'],
            'alamat' => $data['alamat'],
            'banjar_id' => $data['banjar_id'],
            'is_active' => true,
        ]);

        Auth::guard('portal')->login($penduduk);

        return to_route('portal.home')->with('toast', 'Pendaftaran berhasil, selamat datang ' . $penduduk->nama . '!');
    }
}
