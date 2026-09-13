<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Profil\UpdateProfilRequest;
use Illuminate\Http\RedirectResponse;

class ProfilController extends Controller
{
    public function edit()
    {
        $admin = auth('system')->user();

        return view('system.pages.profil', compact('admin'));
    }

    public function update(UpdateProfilRequest $request): RedirectResponse
    {
        auth('system')->user()->update($request->validated());

        return to_route('system.profil.edit')->with('toast', 'Profil berhasil diperbarui.');
    }
}
