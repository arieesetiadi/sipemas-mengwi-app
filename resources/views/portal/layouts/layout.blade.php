<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portal SIPEMAS Mengwi">
    <meta name="keywords" content="portal,sipemas,mengwi">

    <!-- Title -->
    <title>Portal - SIPEMAS Mengwi</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/pace/pace.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toastify/toastify.min.css') }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/horizontal-menu/horizontal-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/neptune.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/neptune.png') }}" />
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
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
</body>

</html>
