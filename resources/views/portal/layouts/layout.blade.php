<!DOCTYPE html>
<html lang="id">

<head>
    @include('global.layouts.meta')

    @include('global.layouts.styles')

    <link href="{{ asset('assets/css/horizontal-menu/horizontal-menu.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg container">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <div class="logo">
                                <a href="{{ route('portal.home') }}">SIPEMAS Mengwi</a>
                            </div>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#">
                                        <i class="material-icons">last_page</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropDown"
                                        data-bs-toggle="dropdown">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="material-icons-outlined"
                                                style="width: 35px; height: 35px; font-size: 35px;">account_circle</i>
                                            <span class="d-inline-block">{{ auth('portal')->user()->nama }}</span>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropDown">
                                        <li>
                                            <span class="dropdown-item-text">
                                                <strong>{{ auth('portal')->user()->nama }}</strong><br>
                                                <small>{{ auth('portal')->user()->email }}</small>
                                            </span>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item align-items-center d-flex gap-2" href="{{ route('portal.profil.edit') }}">
                                                Edit Profil
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger align-items-center d-flex gap-2"
                                                href="{{ route('portal.logout') }}">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="app-menu">
                <div class="container">
                    <ul class="menu-list">
                        <li class="active-page">
                            <a href="{{ route('portal.home') }}"
                                class="{{ request()->routeIs('portal.home') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="app-content">
                @yield('content')
            </div>
        </div>
    </div>

    @include('global.layouts.scripts')
</body>

</html>
