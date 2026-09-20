@extends('system.layouts.auth')

@section('title', 'Masuk - Sistem Admin SIPEMAS Mengwi')

@section('content')
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background"
            style="background-image: url('{{ asset('assets/images/auth-admin.png') }}')"></div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('portal.home') }}">SIPEMAS Mengwi</a>
            </div>
            <div class="d-flex justify-content-start">
                <span class="badge d-inline-block bg-danger mt-4 py-1 px-4">ADMIN DESA</span>
            </div>
            <p class="auth-description">
                Selamat datang di halaman administrasi SIPEMAS Mengwi.<br>
                Silakan masuk untuk mengelola data desa.
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
                        placeholder="contoh@desa.test" value="{{ old('email') }}" required autofocus>

                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    {{-- <a href="#" class="auth-forgot-password float-end">Lupa kata sandi?</a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
