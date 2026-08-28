<?php

namespace App\Http\Controllers\System;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\Pengguna\StorePenggunaRequest;
use App\Http\Requests\System\Pengguna\UpdatePenggunaRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class PenggunaController extends Controller
{
    private function systemRoles()
    {
        return Role::whereNot('label', RoleEnum::Masyarakat->value)->orderBy('label')->get();
    }

    public function index()
    {
        $pengguna = User::system()->with('role')->latest()->get();
        $roles = $this->systemRoles();

        return view('system.pages.pengguna.index', compact('pengguna', 'roles'));
    }

    public function create()
    {
        $roles = $this->systemRoles();

        return view('system.pages.pengguna.form', compact('roles'));
    }

    public function store(StorePenggunaRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return to_route('system.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        $roles = $this->systemRoles();

        return view('system.pages.pengguna.form', compact('pengguna', 'roles'));
    }

    public function update(UpdatePenggunaRequest $request, User $pengguna): RedirectResponse
    {
        $pengguna->update($request->validated());

        return to_route('system.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function updateStatus(User $pengguna): RedirectResponse
    {
        if ($pengguna->id === auth('system')->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $pengguna->update(['is_active' => ! $pengguna->is_active]);

        return back()->with('success', 'Status pengguna berhasil diubah.');
    }
}
