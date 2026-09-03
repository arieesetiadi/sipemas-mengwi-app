@extends('portal.layouts.auth')

@section('title', 'Daftar - Portal Penduduk SIPEMAS Mengwi')

@section('content')
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background"></div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('portal.home') }}">SIPEMAS Mengwi</a>
            </div>
            <div class="d-flex justify-content-start">
                <span class="badge d-inline-block bg-primary mt-4 py-1 px-4">PORTAL Penduduk</span>
            </div>
            <p class="auth-description">
                Daftar akun penduduk untuk mengakses layanan Portal Penduduk.<br>
                Isi data di bawah sesuai identitas Anda.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('portal.register.store') }}" method="POST" id="registerForm" novalidate>
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <div class="m-b-md">
                        <label for="nama" class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Nama lengkap Anda" value="{{ old('nama') }}" required autofocus>
                    </div>

                    <div class="m-b-md">
                        <label for="email" class="form-label required">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="contoh@desa.test" value="{{ old('email') }}" required>
                    </div>

                    <div class="m-b-md">
                        <label for="telepon" class="form-label">Nomor Telepon <span class="text-muted">(opsional)</span></label>
                        <input type="text" name="telepon" class="form-control" id="telepon"
                            placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}" maxlength="20">
                    </div>

                    <div class="m-b-md">
                        <label for="nik" class="form-label required">NIK</label>
                        <input type="text" name="nik" class="form-control" id="nik"
                            placeholder="16 digit NIK" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required>
                    </div>

                    <div class="m-b-md">
                        <label for="banjar_id" class="form-label required">Banjar</label>
                        <select name="banjar_id" class="form-select" id="banjar_id" required>
                            <option value="">-- Pilih Banjar --</option>
                            @foreach ($banjar as $banjar)
                                <option value="{{ $banjar->id }}" {{ old('banjar_id') == $banjar->id ? 'selected' : '' }}>
                                    {{ $banjar->label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="m-b-md">
                        <label for="alamat" class="form-label required">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" rows="2"
                            placeholder="Alamat lengkap sesuai KTP" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="m-b-md">
                        <label for="password" class="form-label required">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Minimal 8 karakter" required>
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label required">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                            placeholder="Ulangi kata sandi" required>
                    </div>
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>

            <div class="text-center mt-5">
                Sudah memiliki akun? <a href="{{ route('portal.login.index') }}">Masuk</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validate/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').validate({
                rules: {
                    nama: { required: true, maxlength: 255 },
                    email: { required: true, email: true },
                    telepon: { maxlength: 20 },
                    nik: { required: true, digits: true, minlength: 16, maxlength: 16 },
                    banjar_id: { required: true },
                    alamat: { required: true, maxlength: 255 },
                    password: { required: true, minlength: 8 },
                    password_confirmation: { required: true, equalTo: '#password' }
                },
                messages: {
                    nama: { required: 'Nama lengkap wajib diisi.' },
                    email: { required: 'Alamat email wajib diisi.', email: 'Format email tidak valid.' },
                    nik: {
                        required: 'NIK wajib diisi.',
                        digits: 'NIK harus angka.',
                        minlength: 'NIK harus 16 digit.',
                        maxlength: 'NIK harus 16 digit.'
                    },
                    banjar_id: { required: 'Banjar wajib dipilih.' },
                    alamat: { required: 'Alamat wajib diisi.', maxlength: 'Alamat maksimal 255 karakter.' },
                    password: { required: 'Kata sandi wajib diisi.', minlength: 'Kata sandi minimal 8 karakter.' },
                    password_confirmation: {
                        required: 'Konfirmasi kata sandi wajib diisi.',
                        equalTo: 'Konfirmasi kata sandi tidak cocok.'
                    }
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
