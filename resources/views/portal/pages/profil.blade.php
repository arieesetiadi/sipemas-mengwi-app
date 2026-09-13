@extends('portal.layouts.layout')

@use('App\Enums\Agama')
@use('App\Enums\JenisKelamin')
@use('Illuminate\Support\Carbon')

@section('title', 'Edit Profil - SIPEMAS Mengwi')

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>Edit Profil</h1>
                        <a href="{{ route('portal.home') }}" class="btn btn-light">
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

            <div class="card">
                <div class="card-body">
                    <form id="profil-form" action="{{ route('portal.profil.update') }}" method="POST" novalidate>
                        @csrf
                        @method('PATCH')

                        <h6 class="fw-bold mb-3">Data Diri</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $penduduk->nama) }}" placeholder="Nama lengkap">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik', $penduduk->nik) }}" maxlength="16" inputmode="numeric">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" placeholder="Sesuai KTP">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @foreach (JenisKelamin::cases() as $jk)
                                        <option value="{{ $jk->value }}"
                                            {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == $jk->value ? 'selected' : '' }}>
                                            {{ $jk->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="agama" id="agama" class="form-select @error('agama') is-invalid @enderror">
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach (Agama::cases() as $agama)
                                        <option value="{{ $agama->value }}"
                                            {{ old('agama', $penduduk->agama) == $agama->value ? 'selected' : '' }}>
                                            {{ $agama->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" name="pekerjaan" id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" placeholder="Contoh: Petani, Karyawan Swasta">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="banjar_id" class="form-label">Banjar <span class="text-danger">*</span></label>
                                <select name="banjar_id" id="banjar_id" class="form-select @error('banjar_id') is-invalid @enderror">
                                    <option value="">-- Pilih Banjar --</option>
                                    @foreach ($banjar as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('banjar_id', $penduduk->banjar_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('banjar_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" name="alamat" id="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    value="{{ old('alamat', $penduduk->alamat) }}" placeholder="Alamat lengkap sesuai KTP">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Kontak & Akun</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $penduduk->email) }}" placeholder="email@contoh.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Nomor Telepon <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="telepon" id="telepon"
                                    class="form-control @error('telepon') is-invalid @enderror"
                                    value="{{ old('telepon', $penduduk->telepon) }}" maxlength="20" placeholder="08xxxxxxxxxx">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Kata Sandi Baru <span class="text-muted">(opsional)</span></label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Kosongkan jika tidak diubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('portal.home') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#profil-form').validate({
                rules: {
                    nama: { required: true, maxlength: 255 },
                    nik: { required: true, digits: true, minlength: 16, maxlength: 16 },
                    tempat_lahir: { required: true, maxlength: 255 },
                    tanggal_lahir: { required: true, date: true },
                    jenis_kelamin: { required: true },
                    agama: { required: true },
                    pekerjaan: { required: true, maxlength: 255 },
                    banjar_id: { required: true },
                    alamat: { required: true, maxlength: 255 },
                    email: { required: true, email: true },
                    telepon: { maxlength: 20 },
                    password: { minlength: 8 }
                },
                messages: {
                    nama: { required: 'Nama lengkap wajib diisi.' },
                    nik: {
                        required: 'NIK wajib diisi.',
                        digits: 'NIK harus angka.',
                        minlength: 'NIK harus 16 digit.',
                        maxlength: 'NIK harus 16 digit.'
                    },
                    tempat_lahir: { required: 'Tempat lahir wajib diisi.' },
                    tanggal_lahir: { required: 'Tanggal lahir wajib diisi.', date: 'Format tanggal lahir tidak valid.' },
                    jenis_kelamin: { required: 'Jenis kelamin wajib dipilih.' },
                    agama: { required: 'Agama wajib dipilih.' },
                    pekerjaan: { required: 'Pekerjaan wajib diisi.' },
                    banjar_id: { required: 'Banjar wajib dipilih.' },
                    alamat: { required: 'Alamat wajib diisi.' },
                    email: { required: 'Alamat email wajib diisi.', email: 'Format email tidak valid.' },
                    password: { minlength: 'Kata sandi minimal 8 karakter.' }
                },
                errorClass: 'is-invalid',
                validClass: 'is-valid',
                errorElement: 'div',
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                }
            });
        });
    </script>
@endpush
