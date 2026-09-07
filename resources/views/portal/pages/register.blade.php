@extends('portal.layouts.auth')

@section('title', 'Daftar - Portal Penduduk SIPEMAS Mengwi')

@section('content')
    @use('App\Enums\Agama')
    @use('App\Enums\JenisKelamin')

    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background"></div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('portal.home') }}">SIPEMAS Mengwi</a>
            </div>
            <div class="d-flex justify-content-start">
                <span class="badge d-inline-block bg-primary mt-4 py-2 px-4">PORTAL Penduduk</span>
            </div>
            <p class="auth-description">
                Daftar akun penduduk untuk mengakses layanan Portal Penduduk.
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
                <div class="auth-credentials mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label required">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                placeholder="Nama lengkap Anda" value="{{ old('nama') }}" required autofocus>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label required">Alamat Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="contoh@desa.test" value="{{ old('email') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="nik" class="form-label required">NIK</label>
                            <input type="text" name="nik" class="form-control" id="nik"
                                placeholder="16 digit NIK" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required>
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                placeholder="Sesuai KTP" value="{{ old('tempat_lahir') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" id="jenis_kelamin" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                @foreach (JenisKelamin::cases() as $jk)
                                    <option value="{{ $jk->value }}" {{ old('jenis_kelamin') == $jk->value ? 'selected' : '' }}>
                                        {{ $jk->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="agama" class="form-label required">Agama</label>
                            <select name="agama" class="form-select" id="agama" required>
                                <option value="">-- Pilih Agama --</option>
                                @foreach (Agama::cases() as $agama)
                                    <option value="{{ $agama->value }}" {{ old('agama') == $agama->value ? 'selected' : '' }}>
                                        {{ $agama->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="telepon" class="form-label">Nomor Telepon <span class="text-muted">(opsional)</span></label>
                            <input type="text" name="telepon" class="form-control" id="telepon"
                                placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}" maxlength="20">
                        </div>

                        <div class="col-md-6">
                            <label for="pekerjaan" class="form-label required">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" id="pekerjaan"
                                placeholder="Contoh: Petani, Karyawan Swasta" value="{{ old('pekerjaan') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label required">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat"
                                placeholder="Alamat lengkap sesuai KTP" value="{{ old('alamat') }}" required>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <label for="password" class="form-label required">Kata Sandi</label>
                                <div role="button" id="toggle-password" tabindex="-1">
                                    <i class="material-icons" style="font-size: 16px">visibility</i>
                                </div>
                            </div>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Minimal 8 karakter" required>
                        </div>
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
                    tempat_lahir: { required: true, maxlength: 255 },
                    tanggal_lahir: { required: true, date: true },
                    jenis_kelamin: { required: true },
                    agama: { required: true },
                    pekerjaan: { required: true, maxlength: 255 },
                    alamat: { required: true, maxlength: 255 },
                    password: { required: true, minlength: 8 }
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
                    tempat_lahir: { required: 'Tempat lahir wajib diisi.' },
                    tanggal_lahir: { required: 'Tanggal lahir wajib diisi.', date: 'Format tanggal lahir tidak valid.' },
                    jenis_kelamin: { required: 'Jenis kelamin wajib dipilih.' },
                    agama: { required: 'Agama wajib dipilih.' },
                    pekerjaan: { required: 'Pekerjaan wajib diisi.' },
                    alamat: { required: 'Alamat wajib diisi.', maxlength: 'Alamat maksimal 255 karakter.' },
                    password: { required: 'Kata sandi wajib diisi.', minlength: 'Kata sandi minimal 8 karakter.' }
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

            // toggle buat liat/sembunyiin kata sandi
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
