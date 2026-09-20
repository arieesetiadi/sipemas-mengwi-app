<?php

namespace App\Http\Controllers\System;

use App\Enums\JenisLampiran;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\Penduduk\StorePendudukRequest;
use App\Http\Requests\System\Penduduk\UpdatePendudukRequest;
use App\Models\Banjar;
use App\Models\Penduduk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::with('banjar')->latest()->get();

        $bolehKelola = in_array(auth('system')->user()->role?->label, [Role::Staf->value, Role::Sekretaris->value]);

        return view('system.pages.penduduk.index', compact('penduduk', 'bolehKelola'));
    }

    public function create()
    {
        $banjar = Banjar::orderBy('label')->get();

        return view('system.pages.penduduk.form', compact('banjar'));
    }

    public function store(StorePendudukRequest $request): RedirectResponse
    {
        Penduduk::create($request->validated());

        return to_route('system.penduduk.index')->with('success', 'Penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        $banjar = Banjar::orderBy('label')->get();
        $riwayatPengajuan = $penduduk->pengajuanSurat()->with('jenisSurat')->latest()->get();

        return view('system.pages.penduduk.form', compact('penduduk', 'banjar', 'riwayatPengajuan'));
    }

    public function update(UpdatePendudukRequest $request, Penduduk $penduduk): RedirectResponse
    {
        $penduduk->update($request->validated());

        return to_route('system.penduduk.index')->with('success', 'Penduduk berhasil diperbarui.');
    }

    public function updateStatus(Penduduk $penduduk): RedirectResponse
    {
        $penduduk->update(['is_active' => ! $penduduk->is_active]);

        return back()->with('success', 'Status penduduk berhasil diubah.');
    }

    public function berkas(Penduduk $penduduk, string $jenis)
    {
        $path = $penduduk->pathBerkas(JenisLampiran::from($jenis));

        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return response()->file(Storage::disk('local')->path($path));
    }
}
