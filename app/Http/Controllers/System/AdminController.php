<?php

namespace App\Http\Controllers\System;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\Admin\StoreAdminRequest;
use App\Http\Requests\System\Admin\UpdateAdminRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    private function systemRoles()
    {
        return Role::whereNot('label', RoleEnum::Penduduk->value)->orderBy('label')->get();
    }

    public function index()
    {
        $admin = User::admin()->with('role')->latest()->get();
        $roles = $this->systemRoles();

        return view('system.pages.admin.index', compact('admin', 'roles'));
    }

    public function create()
    {
        $roles = $this->systemRoles();

        return view('system.pages.admin.form', compact('roles'));
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return to_route('system.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        $roles = $this->systemRoles();

        return view('system.pages.admin.form', compact('admin', 'roles'));
    }

    public function update(UpdateAdminRequest $request, User $admin): RedirectResponse
    {
        $admin->update($request->validated());

        return to_route('system.admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function updateStatus(User $admin): RedirectResponse
    {
        if ($admin->id === auth('system')->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $admin->update(['is_active' => ! $admin->is_active]);

        return back()->with('success', 'Status admin berhasil diubah.');
    }
}
