<!DOCTYPE html>
<html lang="en">

<head>
    @include('global.layouts.meta')

    @include('global.layouts.styles')

    <link href="{{ asset('assets/css/horizontal-menu/horizontal-menu.min.css') }}" rel="stylesheet">
</head>

<body class="">
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
                                <li class="nav-item align-items-center d-flex hidden-on-mobile">
                                    <a class="nav-link nav-notifications-toggle" id="notificationsDropDown"
                                        href="#" data-bs-toggle="dropdown">4</a>
                                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown"
                                        aria-labelledby="notificationsDropDown">
                                        <h6 class="dropdown-header">Notifications</h6>
                                        <div class="notifications-dropdown-list">
                                            @foreach (range(1, 5) as $item)
                                                <a href="#">
                                                    <div class="notifications-dropdown-item">
                                                        <div class="notifications-dropdown-item-image">
                                                            <span class="notifications-badge bg-info text-white">
                                                                <i class="material-icons-outlined">campaign</i>
                                                            </span>
                                                        </div>
                                                        <div class="notifications-dropdown-item-text">
                                                            <p class="bold-notifications-text">
                                                                Donec tempus nisi sed erat
                                                                vestibulum, eu suscipit ex laoreet
                                                            </p>
                                                            <small>19:00</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
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
                                            <a class="dropdown-item align-items-center d-flex gap-2" href="#">
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
                        <li>
                            <a href="#">Pages<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Page 1</a>
                                </li>
                                <li>
                                    <a href="#">Page 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="app-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

    @include('global.layouts.scripts')
</body>

</html>
