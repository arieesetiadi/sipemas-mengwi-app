<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Profil\UpdateProfilRequest;
use App\Models\Banjar;
use Illuminate\Http\RedirectResponse;

class ProfilController extends Controller
{
    public function edit()
    {
        $penduduk = auth('portal')->user();
        $banjar = Banjar::orderBy('label')->get();

        return view('portal.pages.profil', compact('penduduk', 'banjar'));
    }

    public function update(UpdateProfilRequest $request): RedirectResponse
    {
        auth('portal')->user()->update($request->validated());

        return to_route('portal.profil.edit')->with('toast', 'Profil berhasil diperbarui.');
    }
}
