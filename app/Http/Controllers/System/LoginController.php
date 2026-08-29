<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('system.pages.login');
    }

    public function validate(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var SessionGuard $guard */
        $guard = Auth::guard('system');

        if ($guard->attemptWhen(
            $credentials,
            fn (User $user) => ! $user->isPenduduk(),
        )) {
            return to_route('system.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi salah.'])
            ->withInput();
    }
}
