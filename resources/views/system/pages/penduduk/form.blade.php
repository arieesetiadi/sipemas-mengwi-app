@extends('system.layouts.layout')

@php
    $isEdit = isset($penduduk);
    $routeAction = $isEdit ? route('system.penduduk.update', $penduduk) : route('system.penduduk.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? 'Edit Penduduk' : 'Tambah Penduduk';
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>{{ $title }}</h1>
                        <a href="{{ route('system.penduduk.index') }}" class="btn btn-light">
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
                            <form id="penduduk-form" action="{{ $routeAction }}" method="POST">
                                @csrf
                                @method($method)

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $penduduk->nama ?? '') }}" placeholder="Nama lengkap penduduk">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $penduduk->email ?? '') }}" placeholder="email@contoh.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                            value="{{ old('telepon', $penduduk->telepon ?? '') }}" placeholder="08xxxxxxxxxx">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ old('nik', $penduduk->penduduk?->nik ?? '') }}" placeholder="16 digit NIK">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="banjar_id" class="form-label">Banjar <span class="text-danger">*</span></label>
                                        <select name="banjar_id" id="banjar_id" class="form-select @error('banjar_id') is-invalid @enderror">
                                            <option value="">-- Pilih Banjar --</option>
                                            @foreach ($banjar as $banjar)
                                                <option value="{{ $banjar->id }}"
                                                    {{ old('banjar_id', $penduduk->penduduk?->banjar_id ?? '') == $banjar->id ? 'selected' : '' }}>
                                                    {{ $banjar->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('banjar_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat lengkap">{{ old('alamat', $penduduk->penduduk?->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
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
                                        {{ old('is_active', $penduduk->is_active ?? true) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">Aktif</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('system.penduduk.index') }}" class="btn btn-light">Batal</a>
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
            // validasi form di sisi client, rule-nya nyamain backend
            $('#penduduk-form').validate({
                rules: {
                    nama: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    nik: {
                        required: true,
                        digits: true,
                        minlength: 16,
                        maxlength: 16
                    },
                    banjar_id: {
                        required: true
                    },
                    alamat: {
                        required: true,
                        maxlength: 255
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
                    nik: {
                        required: 'NIK wajib diisi.',
                        digits: 'NIK harus angka.',
                        minlength: 'NIK harus 16 digit.',
                        maxlength: 'NIK harus 16 digit.'
                    },
                    banjar_id: {
                        required: 'Banjar wajib dipilih.'
                    },
                    alamat: {
                        required: 'Alamat wajib diisi.',
                        maxlength: 'Alamat maksimal 255 karakter.'
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

            // toggle buat liat/sembunyiin password
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
