@extends('portal.layouts.auth')

@section('title', 'Masuk - Portal Penduduk SIPEMAS Mengwi')

@section('content')
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
                Selamat datang di Portal Penduduk SIPEMAS Mengwi.<br>
                Silakan masuk untuk mengakses layanan penduduk.
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

            <form action="{{ route('portal.login.validate') }}" method="POST" id="loginForm" novalidate>
                @csrf

                <div class="auth-credentials m-b-xxl">
                    <div class="m-b-md">
                        <label for="email" class="form-label required">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="contoh@desa.test" value="{{ old('email', 'penduduk@desa.test') }}" required autofocus>
                    </div>

                    <div>
                        <label for="password" class="form-label required">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" value="i putu roberto" required>
                    </div>
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    {{-- <a href="#" class="auth-forgot-password float-end">Lupa kata sandi?</a> --}}
                </div>
            </form>

            <div class="text-center mt-5">
                Belum memiliki akun? <a href="{{ route('portal.register.index') }}">Daftar</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validate/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').validate({
                rules: {
                    email: { required: true, email: true },
                    password: { required: true }
                },
                messages: {
                    email: { required: 'Alamat email wajib diisi.', email: 'Format email tidak valid.' },
                    password: { required: 'Kata sandi wajib diisi.' }
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
