<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('system')->logout();

        return to_route('system.login.index');
    }
}
