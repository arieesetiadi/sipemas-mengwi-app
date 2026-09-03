<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Admin\StoreAdminRequest;
use App\Http\Requests\System\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    private function systemRoles()
    {
        return Role::orderBy('label')->get();
    }

    public function index()
    {
        $admin = Admin::with('role')->latest()->get();
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
        Admin::create($request->validated());

        return to_route('system.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(Admin $admin)
    {
        $roles = $this->systemRoles();

        return view('system.pages.admin.form', compact('admin', 'roles'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        $admin->update($request->validated());

        return to_route('system.admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function updateStatus(Admin $admin): RedirectResponse
    {
        if ($admin->id === auth('system')->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $admin->update(['is_active' => ! $admin->is_active]);

        return back()->with('success', 'Status admin berhasil diubah.');
    }
}
