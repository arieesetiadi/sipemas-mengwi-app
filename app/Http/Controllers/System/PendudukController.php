<?php

namespace App\Http\Controllers\System;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\Penduduk\StorePendudukRequest;
use App\Http\Requests\System\Penduduk\UpdatePendudukRequest;
use App\Models\Banjar;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class PendudukController extends Controller
{
    private function pendudukRoleId()
    {
        return Role::where('label', RoleEnum::Penduduk->value)->value('id');
    }

    public function index()
    {
        $penduduk = User::pendudukUser()->with(['role', 'penduduk.banjar'])->latest()->get();

        return view('system.pages.penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        $banjar = Banjar::orderBy('label')->get();

        return view('system.pages.penduduk.form', compact('banjar'));
    }

    public function store(StorePendudukRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['nik', 'alamat', 'banjar_id']);
        $data['role_id'] = $this->pendudukRoleId();

        $user = User::create($data);

        $user->penduduk()->create($request->only(['nik', 'alamat', 'banjar_id']));

        return to_route('system.penduduk.index')->with('success', 'Penduduk berhasil ditambahkan.');
    }

    public function edit(User $penduduk)
    {
        $banjar = Banjar::orderBy('label')->get();

        return view('system.pages.penduduk.form', compact('penduduk', 'banjar'));
    }

    public function update(UpdatePendudukRequest $request, User $penduduk): RedirectResponse
    {
        $penduduk->update($request->safe()->except(['nik', 'alamat', 'banjar_id']));

        $penduduk->penduduk()->updateOrCreate(
            ['user_id' => $penduduk->id],
            $request->only(['nik', 'alamat', 'banjar_id']),
        );

        return to_route('system.penduduk.index')->with('success', 'Penduduk berhasil diperbarui.');
    }

    public function updateStatus(User $penduduk): RedirectResponse
    {
        if ($penduduk->id === auth('system')->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $penduduk->update(['is_active' => ! $penduduk->is_active]);

        return back()->with('success', 'Status penduduk berhasil diubah.');
    }
}
