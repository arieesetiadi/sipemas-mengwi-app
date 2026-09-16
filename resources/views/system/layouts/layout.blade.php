<!doctype html>
<html lang="id">

<head>
    @include('global.layouts.meta')

    @include('global.layouts.styles')
</head>

@php
    $admin = auth('system')->user();
@endphp

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="{{ route('system.dashboard') }}" class="logo-icon"><span class="logo-text">SIPEMAS</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="{{ route('system.profil.edit') }}">
                        <img src="{{ asset('assets/images/avatars/user.png') }}" />
                        <span class="activity-indicator"></span>
                        <span class="user-info-text">
                            {{ $admin->nama ?? 'Admin' }}
                            <br />
                            <span class="user-state-info">{{ $admin->email ?? '' }}</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">Utama</li>
                    <li class="{{ request()->routeIs('system.dashboard') ? 'active-page' : '' }}">
                        <a href="{{ route('system.dashboard') }}" class="{{ request()->routeIs('system.dashboard') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">dashboard</i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-title">Layanan</li>
                    <li class="{{ request()->routeIs('system.pengajuan.*') ? 'active-page' : '' }}">
                        <a href="{{ route('system.pengajuan.index') }}"
                            class="{{ request()->routeIs('system.pengajuan.*') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">description</i>
                            Pengajuan Surat
                        </a>
                    </li>
                    <li class="sidebar-title">Data Master</li>
                    <li class="{{ request()->routeIs('system.admin.*') ? 'active-page' : '' }}">
                        <a href="{{ route('system.admin.index') }}"
                            class="{{ request()->routeIs('system.admin.*') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">group</i>
                            Admin
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('system.penduduk.*') ? 'active-page' : '' }}">
                        <a href="{{ route('system.penduduk.index') }}"
                            class="{{ request()->routeIs('system.penduduk.*') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">people</i>
                            Penduduk
                        </a>
                    </li>
                    <li class="sidebar-title">Lainnya</li>
                    <li>
                        <a href="{{ route('system.logout') }}" class="fw-bold">
                            <i class="material-icons-two-tone">logout</i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#">
                                        <i class="material-icons">first_page</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">@yield('content')</div>
        </div>
    </div>

    {{-- plugin khusus layout system --}}
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

    @include('global.layouts.scripts')
</body>

</html>
