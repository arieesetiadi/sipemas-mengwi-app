<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="System SIPEMAS Mengwi" />
    <meta name="keywords" content="admin,dashboard" />

    <title>System - SIPEMAS Mengwi</title>

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/pace/pace.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/toastify/toastify.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />

    @stack('styles')

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/neptune.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/neptune.png') }}" />
</head>

@php
    $isLoggedIn = auth('system')->check();
    $admin = auth('system')->user();
@endphp

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="{{ route('system.dashboard') }}" class="logo-icon"><span class="logo-text">System</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
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
                    <li class="sidebar-title">Apps</li>
                    <li class="{{ request()->routeIs('system.dashboard') ? 'active-page' : '' }}">
                        <a href="{{ route('system.dashboard') }}" class="{{ request()->routeIs('system.dashboard') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">dashboard</i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="material-icons-two-tone">star</i>Pages
                            <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">Page 1</a>
                            </li>
                            <li>
                                <a href="#">Page 2</a>
                            </li>
                        </ul>
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
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link nav-notifications-toggle" id="notificationsDropDown"
                                        href="#" data-bs-toggle="dropdown">4</a>
                                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown"
                                        aria-labelledby="notificationsDropDown">
                                        <h6 class="dropdown-header">Notifications</h6>
                                        <div class="notifications-dropdown-list">
                                            @foreach (range(1, 5) as $item)
                                                <a href="#">
                                                    <div
                                                        class="notifications-dropdown-item {{ $loop->first ? 'bg-light' : '' }}">
                                                        <div class="notifications-dropdown-item-image">
                                                            <span class="notifications-badge bg-info text-white">
                                                                <i class="material-icons-outlined">campaign</i>
                                                            </span>
                                                        </div>
                                                        <div class="notifications-dropdown-item-text">
                                                            <p class="bold-notifications-text">
                                                                Donec tempus nisi sed erat vestibulum, eu suscipit ex
                                                                laoreet
                                                            </p>
                                                            <small>19:00</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">@yield('content')</div>
        </div>
    </div>

    <script>
        const baseUrl = "{{ url('/') }}";
        const csrfToken = "{{ csrf_token() }}";
        const toastText = `{{ session('toast') }}`;
    </script>

    <script src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastify/toastify-js.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
