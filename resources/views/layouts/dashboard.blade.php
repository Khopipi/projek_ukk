<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->

    <head>
        <title>@yield('title') - Desa Sruni</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Aplikasi Management Desa Sruni - Sistem Informasi Pelayanan Desa">
        <meta name="keywords" content="Desa Sruni, Pelayanan Desa, Pengajuan Surat, Pengaduan Desa">
        <meta name="author" content="CodedThemes">

        <!-- [Favicon] icon -->
        <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

        <!-- [Google Font] Family -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
            id="main-font-link">

        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">

        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">

        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    </head>
    <!-- [Head] end -->

    <!-- [Body] Start -->
    <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <!-- [ Sidebar Menu ] start -->
        <nav class="pc-sidebar">
            <div class="navbar-wrapper">
                <div class="m-header justify-content-center">
                    <a href="/" class="b-brand text-dark text-capitalize fw-bold">
                        <!-- ========   Change your logo from here   ============ -->
                        <span class="fs-4">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'User' }} Dashboard</span>
                    </a>
                </div>
                <div class="navbar-content">
                    <ul class="pc-navbar">
                        <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>

                        @auth
                            @if (Auth::user()->role === 'admin')
                                @include('admin.sidebar')
                            @else
                                @include('user.sidebar')
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- [ Sidebar Menu ] end -->

        <!-- [ Header Topbar ] start -->
        <header class="pc-header">
            <div class="header-wrapper">
                <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled">
                        <!-- ======= Menu collapse Icon ===== -->
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="dropdown pc-h-item d-inline-flex d-md-none">
                            <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ti ti-search"></i>
                            </a>
                            <div class="dropdown-menu pc-h-dropdown drp-search">
                                <form class="px-3">
                                    <div class="form-group mb-0 d-flex align-items-center">
                                        <i data-feather="search"></i>
                                        <input type="search" class="form-control border-0 shadow-none"
                                            placeholder="Search here. . .">
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="pc-h-item d-none d-md-inline-flex">
                            <form class="header-search">
                                <i data-feather="search" class="icon-search"></i>
                                <input type="search" class="form-control" placeholder="Search here. . .">
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- [Mobile Media Block] end -->
                <div class="ms-auto">
                    <ul class="list-unstyled">
                                <li class="dropdown pc-h-item header-user-profile">
                                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                        href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                                        aria-expanded="false">
                                        @auth
                                            @php
                                                // header avatar fallback: use uploaded avatar or generate a small gender-aware SVG
                                                $hdrAvatar = Auth::user()->avatar ?? null;
                                                if (!$hdrAvatar) {
                                                    $name = Auth::user()->name;
                                                    $gender = Auth::user()->jenis_kelamin ?? null;
                                                    $initials = collect(explode(' ', trim($name)))->map(function($p){ return strtoupper(substr($p,0,1)); })->take(2)->join('');
                                                    $bg = '#6a11cb';
                                                    $fg = '#ffffff';
                                                    if ($gender) {
                                                        if (stripos($gender, 'laki') !== false || stripos($gender, 'l') === 0) {
                                                            $bg = '#2575fc';
                                                        } elseif (stripos($gender, 'perempuan') !== false || stripos($gender, 'p') === 0) {
                                                            $bg = '#ff6b81';
                                                        }
                                                    }
                                                    $size = 64;
                                                    $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='$size' height='$size' viewBox='0 0 $size $size'>".
                                                           "<rect width='100%' height='100%' rx='50%' fill='$bg'/>".
                                                           "<text x='50%' y='54%' font-family='Arial, Helvetica, sans-serif' font-size='".($size*0.36)."' fill='$fg' text-anchor='middle' dominant-baseline='middle'>".$initials."</text>".
                                                           "</svg>";
                                                    $hdrAvatar = 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                                                }
                                            @endphp
                                            <img src="{{ $hdrAvatar }}" alt="user-image" class="user-avtar">
                                            <span>{{ Auth::user()->name }}</span>
                                        @else
                                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" class="user-avtar">
                                            <span>Guest</span>
                                        @endauth
                                    </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header">
                                    <div class="d-flex mb-1 align-items-center">
                                        <div class="flex-shrink-0">
                                            @auth
                                                @php
                                                    $thumb = Auth::user()->avatar ?? null;
                                                    if (!$thumb) {
                                                        $name = Auth::user()->name;
                                                        $gender = Auth::user()->jenis_kelamin ?? null;
                                                        $initials = collect(explode(' ', trim($name)))->map(function($p){ return strtoupper(substr($p,0,1)); })->take(2)->join('');
                                                        $bg = '#6a11cb';
                                                        $fg = '#ffffff';
                                                        if ($gender) {
                                                            if (stripos($gender, 'laki') !== false || stripos($gender, 'l') === 0) {
                                                                $bg = '#2575fc';
                                                            } elseif (stripos($gender, 'perempuan') !== false || stripos($gender, 'p') === 0) {
                                                                $bg = '#ff6b81';
                                                            }
                                                        }
                                                        $size = 48;
                                                        $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='$size' height='$size' viewBox='0 0 $size $size'>".
                                                               "<rect width='100%' height='100%' rx='50%' fill='$bg'/>".
                                                               "<text x='50%' y='54%' font-family='Arial, Helvetica, sans-serif' font-size='".($size*0.36)."' fill='$fg' text-anchor='middle' dominant-baseline='middle'>".$initials."</text>".
                                                               "</svg>";
                                                        $thumb = 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                                                    }
                                                @endphp
                                                <img src="{{ $thumb }}" alt="user-image" class="user-avtar wid-35">
                                            @else
                                                <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" class="user-avtar wid-35">
                                            @endauth
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            @auth
                                                <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                                <span>{{ ucfirst(Auth::user()->role) }}</span>
                                            @else
                                                <h6 class="mb-1">Guest</h6>
                                                <span>Not Logged In</span>
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content" id="mysrpTabContent">
                                    <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                        aria-labelledby="drp-t1" tabindex="0">

                                        @auth
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ti ti-power"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="dropdown-item">
                                                <i class="ti ti-login"></i>
                                                <span>Login</span>
                                            </a>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- [ Header ] end -->

        <!-- [ Main Content ] start -->
        <div class="pc-container">
            @yield('content')
        </div>
        <!-- [ Main Content ] end -->

        <!-- [ Footer ] start -->
        <footer class="pc-footer">
            <div class="footer-wrapper container-fluid">
                <div class="row">
                    <div class="col-sm my-1">
                        <p class="m-0">© {{ date('Y') }} Aplikasi Desa Sruni. Hak Cipta Dilindungi.</p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="/">Home</a></li>
                            <li class="list-inline-item"><a href="/contact-us">Kontak</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- [ Footer ] end -->

        <!-- [Page Specific JS] start -->
        <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
        <!-- [Page Specific JS] end -->

        <!-- Required Js -->
        <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

        <script>
            layout_change('light');
        </script>

        <script>
            change_box_container('false');
        </script>

        <script>
            layout_rtl_change('false');
        </script>

        <script>
            preset_change("preset-1");
        </script>

        <script>
            font_change("Public-Sans");
        </script>

        <script>
            if (window.location.hash === '#_=_') {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>

        {{-- Page-specific scripts from child views --}}
        @yield('scripts_content')
    </body>
    <!-- [Body] end -->

</html>
