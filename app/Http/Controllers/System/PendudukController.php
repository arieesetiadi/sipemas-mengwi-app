<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Penduduk\StorePendudukRequest;
use App\Http\Requests\System\Penduduk\UpdatePendudukRequest;
use App\Models\Banjar;
use App\Models\Penduduk;
use Illuminate\Http\RedirectResponse;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::with('banjar')->latest()->get();

        return view('system.pages.penduduk.index', compact('penduduk'));
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

        return view('system.pages.penduduk.form', compact('penduduk', 'banjar'));
    }

    public function update(UpdatePendudukRequest $request, Penduduk $penduduk): RedirectResponse
    {
        $penduduk->update($request->validated());

        return to_route('system.penduduk.index')->with('success', 'Penduduk berhasil diperbarui.');
    }

    public function updateStatus(Penduduk $penduduk): RedirectResponse
    {
        if ($penduduk->id === auth('system')->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $penduduk->update(['is_active' => ! $penduduk->is_active]);

        return back()->with('success', 'Status penduduk berhasil diubah.');
    }
}
