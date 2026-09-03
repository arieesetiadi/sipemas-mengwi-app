<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Auth\LoginRequest;
use App\Models\Penduduk;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('portal.pages.login');
    }

    public function validate(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var SessionGuard $guard */
        $guard = Auth::guard('portal');

        if ($guard->attemptWhen(
            $credentials,
            fn (Penduduk $penduduk) => $penduduk->is_active,
        )) {
            return to_route('portal.home')->with('toast', 'Selamat datang kembali, ' . $guard->user()->nama . '!');
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi salah.'])
            ->withInput();
    }
}
