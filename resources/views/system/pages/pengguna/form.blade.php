@extends('system.layouts.layout')

@php
    $isEdit = isset($pengguna);
    $routeAction = $isEdit ? route('system.pengguna.update', $pengguna) : route('system.pengguna.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna';
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>{{ $title }}</h1>
                        <a href="{{ route('system.pengguna.index') }}" class="btn btn-light">
                            <i class="material-icons">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form id="pengguna-form" action="{{ $routeAction }}" method="POST">
                                @csrf
                                @method($method)

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $pengguna->nama ?? '') }}" placeholder="Nama lengkap pengguna">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $pengguna->email ?? '') }}" placeholder="email@contoh.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                            value="{{ old('telepon', $pengguna->telepon ?? '') }}" placeholder="08xxxxxxxxxx">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                        <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror">
                                            <option value="">-- Pilih Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $pengguna->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <label for="password" class="form-label">Password
                                                @if (!$isEdit)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <div role="button" id="toggle-password" tabindex="-1">
                                                <i class="material-icons" style="font-size: 16px">visibility</i>
                                            </div>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ $isEdit ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-5 form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        class="form-check-input"
                                        {{ old('is_active', $pengguna->is_active ?? true) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">Aktif</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('system.pengguna.index') }}" class="btn btn-light">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#pengguna-form').validate({
                rules: {
                    nama: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    role_id: {
                        required: true
                    },
                    password: {
                        @if (!$isEdit)
                            required: true,
                        @endif
                        minlength: 8
                    }
                },
                messages: {
                    nama: {
                        required: 'Nama wajib diisi.',
                        maxlength: 'Nama maksimal 255 karakter.'
                    },
                    email: {
                        required: 'Email wajib diisi.',
                        email: 'Format email tidak valid.'
                    },
                    role_id: {
                        required: 'Role wajib dipilih.'
                    },
                    password: {
                        required: 'Password wajib diisi.',
                        minlength: 'Password minimal 8 karakter.'
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#toggle-password').on('click', function () {
                var input = $('#password');
                var icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.text('visibility_off');
                } else {
                    input.attr('type', 'password');
                    icon.text('visibility');
                }
            });
        });
    </script>
@endpush
