@extends('system.layouts.auth')

@section('title', 'Login - SIPEMAS Mengwi')

@section('content')
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background"></div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('portal.home') }}">SIPEMAS Mengwi</a>
            </div>
            <p class="auth-description">
                Silakan masuk untuk mengakses halaman administrasi.<br>
                Belum punya akun? Hubungi admin desa.
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

            <form action="{{ route('system.login.validate') }}" method="POST">
                @csrf

                <div class="auth-credentials m-b-xxl">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control m-b-md" id="email"
                        placeholder="contoh@desa.test" value="{{ old('email', 'staf@desa.test') }}" required autofocus>

                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" value="staf" required>
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    {{-- <a href="#" class="auth-forgot-password float-end">Lupa kata sandi?</a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
