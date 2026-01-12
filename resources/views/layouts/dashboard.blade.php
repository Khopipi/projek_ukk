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
        <link rel="stylesheet" href="{{ asset('css/dashboard-modern.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modern-ui.css') }}">

        <style>
            /* ===== PREMIUM MODERN UI - HIGH CONTRAST ===== */
            * {
                box-sizing: border-box;
            }

            :root {
                --primary: #5b6ef5;
                --primary-dark: #4b5dd9;
                --secondary: #6c757d;
                --accent: #ff6b9d;
                --success: #2dce89;
                --warning: #ffa500;
                --danger: #f5365c;
            }

            body {
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f3f4f6 100%) !important;
                background-attachment: fixed !important;
                color: #2d3748 !important;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                min-height: 100vh;
            }

            /* ===== SIDEBAR PREMIUM ===== */
            .pc-sidebar {
                background: #ffffff !important;
                box-shadow: 2px 0 12px rgba(91, 110, 245, 0.12) !important;
                border-right: 1px solid #e9ecef !important;
            }

            .pc-sidebar .m-header {
                background: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%) !important;
                padding: 40px 25px !important;
                border-radius: 0 0 20px 0 !important;
                box-shadow: 0 4px 20px rgba(91, 110, 245, 0.15) !important;
                position: relative;
                overflow: hidden;
                border-bottom: 4px solid #00d4ff;
            }

            .pc-sidebar .m-header::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
                border-radius: 50%;
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }

            .pc-sidebar .m-header .b-brand {
                color: white !important;
                font-size: 24px !important;
                font-weight: 900 !important;
                letter-spacing: 2px !important;
                position: relative;
                z-index: 1;
                text-shadow: 0 4px 15px rgba(0,0,0,0.4);
            }

            .pc-sidebar .navbar-content {
                padding: 30px 12px !important;
            }

            .pc-sidebar .pc-navbar {
                list-style: none !important;
            }

            .pc-sidebar .pc-item {
                margin: 12px 8px !important;
                border-radius: 16px !important;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                position: relative;
            }

            .pc-sidebar .pc-item::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                width: 5px;
                height: 0;
                background: linear-gradient(180deg, #7685f0, #5b6ef5);
                transition: height 0.3s ease !important;
                z-index: 1;
            }

            .pc-sidebar .pc-item:hover::before {
                height: 100%;
            }

            .pc-sidebar .pc-item .pc-link {
                color: #495057 !important;
                padding: 16px 20px !important;
                border-radius: 14px !important;
                transition: all 0.3s ease !important;
                display: flex !important;
                align-items: center !important;
                font-weight: 600 !important;
                position: relative;
            }

            .pc-sidebar .pc-item .pc-link:hover {
                background: #f0f2ff !important;
                color: #5b6ef5 !important;
                transform: translateX(10px) !important;
                padding-left: 30px !important;
            }

            .pc-sidebar .pc-item.active .pc-link {
                background: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%) !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(91, 110, 245, 0.25) !important;
                font-weight: 700 !important;
            }

            .pc-sidebar .pc-micon {
                font-size: 22px !important;
                margin-right: 14px !important;
                transition: transform 0.3s ease !important;
            }

            .pc-sidebar .pc-item.active .pc-micon {
                transform: scale(1.2);
            }

            .pc-sidebar .collapse .list-unstyled {
                background: #f0f2ff !important;
                border-left: 3px solid #5b6ef5 !important;
                border-radius: 12px !important;
                margin: 12px 8px !important;
                padding-left: 15px !important;
                backdrop-filter: blur(10px);
            }

            .pc-sidebar .collapse .pc-sublink {
                color: #495057 !important;
                padding: 12px 14px !important;
                border-radius: 10px !important;
                font-size: 14px !important;
                transition: all 0.3s ease !important;
                display: block !important;
                margin-bottom: 8px !important;
                position: relative;
                padding-left: 28px !important;
            }

            .pc-sidebar .collapse .pc-sublink::before {
                content: '→';
                position: absolute;
                left: 12px;
                color: #5b6ef5;
                font-weight: bold;
            }

            .pc-sidebar .collapse .pc-sublink:hover {
                background: #e9ecf5 !important;
                color: #5b6ef5 !important;
                transform: translateX(5px) !important;
            }

            /* ===== HEADER PREMIUM ===== */
            .pc-header {
                background: white !important;
                border-bottom: 1px solid #e9ecef !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                padding: 16px 35px !important;
            }

            .pc-header .header-search input {
                background: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
                border-radius: 10px !important;
                padding: 10px 16px 10px 38px !important;
                color: #2d3748 !important;
                font-weight: 500 !important;
                transition: all 0.3s ease !important;
                width: 100%;
            }

            .pc-header .header-search input::placeholder {
                color: #adb5bd;
            }

            .pc-header .header-search input:focus {
                background: white !important;
                border-color: #5b6ef5 !important;
                box-shadow: 0 0 0 3px rgba(91, 110, 245, 0.1) !important;
                outline: none !important;
            }

            .pc-header .icon-search {
                position: absolute !important;
                left: 12px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                color: #6c757d !important;
            }

            .pc-header .user-avtar {
                width: 42px !important;
                height: 42px !important;
                border-radius: 50% !important;
                border: 2px solid #5b6ef5 !important;
                box-shadow: 0 2px 8px rgba(91, 110, 245, 0.2) !important;
            }

            .pc-header .header-user-profile .pc-head-link {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 8px 16px !important;
                border-radius: 10px !important;
                background: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
                transition: all 0.3s ease !important;
                color: #2d3748 !important;
                font-weight: 600;
            }

            .pc-header .header-user-profile .pc-head-link:hover {
                background: #f0f2ff !important;
                border-color: #5b6ef5 !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px rgba(91, 110, 245, 0.15) !important;
                color: #5b6ef5 !important;
            }

            /* ===== CARDS PREMIUM ===== */
            .card {
                border: 1px solid #e9ecef !important;
                border-radius: 12px !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                transition: all 0.3s ease !important;
                background: white !important;
                position: relative;
                overflow: hidden;
            }

            .card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #5b6ef5, #7685f0);
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.4s ease !important;
            }

            .card:hover {
                transform: translateY(-8px) !important;
                box-shadow: 0 8px 24px rgba(91, 110, 245, 0.15) !important;
                border-color: #5b6ef5 !important;
            }

            .card:hover::before {
                transform: scaleX(1);
            }

            .card-header {
                background: #f8f9fa !important;
                border-bottom: 1px solid #e9ecef !important;
                padding: 20px 24px !important;
            }

            .card-header h5 {
                color: #2d3748 !important;
                font-weight: 700 !important;
                font-size: 17px !important;
                margin: 0 !important;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .card-body {
                padding: 24px !important;
                color: #2d3748 !important;
            }

            /* ===== BUTTONS PREMIUM ===== */
            .btn {
                border-radius: 10px !important;
                font-weight: 700 !important;
                padding: 11px 24px !important;
                transition: all 0.3s ease !important;
                border: none !important;
                display: inline-flex !important;
                align-items: center !important;
                gap: 8px !important;
                font-size: 13px !important;
                position: relative;
                overflow: hidden;
                text-transform: capitalize;
                letter-spacing: 0.3px;
            }

            .btn::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s ease !important;
            }

            .btn:active::after {
                width: 300px;
                height: 300px;
            }

            .btn-primary {
                background: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%) !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(91, 110, 245, 0.3) !important;
                border: none;
            }

            .btn-primary:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 20px rgba(91, 110, 245, 0.4) !important;
                color: white !important;
            }

            .btn-secondary {
                background: #f8f9fa !important;
                color: #5b6ef5 !important;
                border: 1px solid #dee2e6 !important;
            }

            .btn-secondary:hover {
                background: #f0f2ff !important;
                border-color: #5b6ef5 !important;
                color: #5b6ef5 !important;
                transform: translateY(-3px) !important;
            }

            .btn-success {
                background: linear-gradient(135deg, #2dce89 0%, #26c381 100%) !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3) !important;
            }

            .btn-success:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 20px rgba(45, 206, 137, 0.4) !important;
            }

            .btn-danger {
                background: linear-gradient(135deg, #f5365c 0%, #e91e63 100%) !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(245, 54, 92, 0.3) !important;
            }

            .btn-danger:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 20px rgba(245, 54, 92, 0.4) !important;
            }

            .btn-warning {
                background: linear-gradient(135deg, #ffa500 0%, #ff9500 100%) !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(255, 165, 0, 0.3) !important;
            }

            .btn-warning:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 20px rgba(255, 165, 0, 0.4) !important;
            }

            /* ===== FORMS PREMIUM ===== */
            .form-label {
                color: #495057 !important;
                font-weight: 600 !important;
                margin-bottom: 10px !important;
                font-size: 14px !important;
                text-transform: none;
                letter-spacing: 0;
            }

            .form-control,
            .form-select,
            textarea.form-control {
                border: 1px solid #dee2e6 !important;
                border-radius: 8px !important;
                padding: 12px 14px !important;
                font-size: 14px !important;
                background: #f8f9fa !important;
                color: #2d3748 !important;
                font-weight: 500 !important;
                transition: all 0.3s ease !important;
            }

            .form-control::placeholder,
            textarea.form-control::placeholder {
                color: #adb5bd;
            }

            .form-control:focus,
            .form-select:focus,
            textarea.form-control:focus {
                border-color: #5b6ef5 !important;
                background: white !important;
                box-shadow: 0 0 0 3px rgba(91, 110, 245, 0.1) !important;
                outline: none !important;
                color: #2d3748 !important;
            }

            /* ===== BADGES PREMIUM ===== */
            .badge {
                padding: 8px 14px !important;
                border-radius: 10px !important;
                font-weight: 700 !important;
                font-size: 12px !important;
                text-transform: none !important;
                letter-spacing: 0 !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
            }

            .badge-primary {
                background: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%) !important;
                color: white !important;
            }

            .badge-success {
                background: linear-gradient(135deg, #2dce89 0%, #26c381 100%) !important;
                color: white !important;
            }

            .badge-danger {
                background: linear-gradient(135deg, #f5365c 0%, #e91e63 100%) !important;
                color: white !important;
            }

            .badge-warning {
                background: linear-gradient(135deg, #ffa500 0%, #ff9500 100%) !important;
                color: white !important;
            }

            .badge-diproses {
                background: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%) !important;
                color: white !important;
            }

            .badge-disetujui {
                background: linear-gradient(135deg, #2dce89 0%, #26c381 100%) !important;
                color: white !important;
            }

            .badge-menunggu {
                background: linear-gradient(135deg, #ffa500 0%, #ff9500 100%) !important;
                color: white !important;
            }

            .badge-ditolak {
                background: linear-gradient(135deg, #f5365c 0%, #e91e63 100%) !important;
                color: white !important;
            }

            .badge-selesai {
                background: linear-gradient(135deg, #2dce89 0%, #26c381 100%) !important;
                color: white !important;
            }

            /* ===== TABLES ===== */
            .table {
                color: #2d3748 !important;
            }

            .table thead th {
                background: #f8f9fa !important;
                color: #495057 !important;
                font-weight: 700 !important;
                border: 1px solid #dee2e6 !important;
                padding: 16px !important;
                text-transform: none;
                letter-spacing: 0;
            }

            .table tbody td {
                padding: 14px !important;
                border-bottom: 1px solid #e9ecef !important;
                color: #2d3748 !important;
            }

            .table tbody tr:hover {
                background: #f8f9fa !important;
            }

            /* ===== ALERTS ===== */
            .alert {
                border-radius: 10px !important;
                border: 1px solid !important;
                padding: 16px 20px !important;
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
            }

            .alert-danger {
                background: #fff5f7 !important;
                border-color: #ffd6de !important;
                color: #f5365c !important;
            }

            .alert-success {
                background: #f0fdf4 !important;
                border-color: #d4f8e0 !important;
                color: #2dce89 !important;
            }

            .alert-warning {
                background: #fffbf0 !important;
                border-color: #ffe4bf !important;
                color: #ff9500 !important;
            }

            /* ===== SCROLLBAR ===== */
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f8f9fa;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #5b6ef5, #7685f0);
                border-radius: 5px;
                transition: background 0.3s ease;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #7685f0, #5b6ef5);
            }
        </style>
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
                <div class="m-header">
                    <a href="/" class="b-brand text-dark text-capitalize fw-bold">
                        <!-- ========   Change your logo from here   ============ -->
                        <span class="fs-5">{{ Auth::check() ? Auth::user()->role === 'admin' ? '🏢 Admin' : '👤 User' : 'Dashboard' }}</span>
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
                                        // header avatar - check if it's a built-in avatar or uploaded one
                                        $avatarUrl = asset('assets/images/user/avatar-1.jpg'); // default
                                        if (Auth::user()->avatar) {
                                            if (file_exists(public_path('assets/images/user/' . Auth::user()->avatar))) {
                                                $avatarUrl = asset('assets/images/user/' . Auth::user()->avatar);
                                            } elseif (file_exists(storage_path('app/public/' . Auth::user()->avatar))) {
                                                $avatarUrl = asset('storage/' . Auth::user()->avatar);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $avatarUrl }}" alt="user-image" class="user-avtar">
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
                                                    // dropdown avatar - check if it's a built-in avatar or uploaded one
                                                    $thumbUrl = asset('assets/images/user/avatar-1.jpg'); // default
                                                    if (Auth::user()->avatar) {
                                                        if (file_exists(public_path('assets/images/user/' . Auth::user()->avatar))) {
                                                            $thumbUrl = asset('assets/images/user/' . Auth::user()->avatar);
                                                        } elseif (file_exists(storage_path('app/public/' . Auth::user()->avatar))) {
                                                            $thumbUrl = asset('storage/' . Auth::user()->avatar);
                                                        }
                                                    }
                                                @endphp
                                                <img src="{{ $thumbUrl }}" alt="user-image" class="user-avtar wid-35">
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
