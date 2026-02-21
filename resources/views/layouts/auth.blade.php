<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->

    <head>

        <title>@yield('title')</title>

        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description"
            content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
        <meta name="keywords"
            content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
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

        <style>
            /* ===== PREMIUM MODERN AUTH UI ===== */
            * {
                box-sizing: border-box;
            }

            :root {
                --primary-blue: #3b82f6;
                --primary-blue-dark: #1e40af;
                --primary-blue-light: #60a5fa;
                --primary-blue-lighter: #dbeafe;
            }

            body {
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 25%, #4a90e2 50%, #5fa3f0 75%, #7eb3f5 100%) !important;
                background-attachment: fixed !important;
                font-family: 'Public Sans', sans-serif !important;
                min-height: 100vh;
            }

            .auth-main {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }

            .auth-wrapper.v3 {
                width: 100%;
                max-width: 450px;
            }

            .auth-form {
                background: rgba(255, 255, 255, 0.98) !important;
                border-radius: 20px !important;
                padding: 40px !important;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }

            .auth-form::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(90deg, #3b82f6, #60a5fa, #1e40af);
            }

            .auth-header {
                display: flex;
                justify-content: center;
                margin-bottom: 30px;
            }

            .auth-header .navbar-brand {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .auth-header .navbar-brand img {
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
                transition: all 0.3s ease;
            }

            .auth-header .navbar-brand img:hover {
                transform: scale(1.05);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            }

            /* ===== CARD STYLING ===== */
            .card {
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }

            .card-body {
                padding: 0 !important;
            }

            /* ===== HEADING STYLING ===== */
            h2, h3, h4, h5 {
                color: #1e3c72 !important;
                font-weight: 800 !important;
                letter-spacing: -0.5px;
            }

            h2 {
                font-size: 28px !important;
            }

            h3 {
                font-size: 24px !important;
            }

            h5 {
                font-size: 16px !important;
                color: #3b82f6 !important;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            /* ===== FORM LABEL ===== */
            .form-label {
                color: #1e40af !important;
                font-weight: 700 !important;
                font-size: 13px !important;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                margin-bottom: 8px !important;
            }

            /* ===== FORM CONTROLS ===== */
            .form-control,
            .form-select,
            textarea.form-control {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important;
                border: 2px solid #dbeafe !important;
                border-radius: 10px !important;
                padding: 12px 16px !important;
                color: #1e3c72 !important;
                font-weight: 500;
                font-size: 14px;
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
            }

            .form-control:focus,
            .form-select:focus,
            textarea.form-control:focus {
                background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%) !important;
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 4px 15px rgba(59, 130, 246, 0.2) !important;
                outline: none !important;
                color: #1e3c72 !important;
            }

            .form-control::placeholder,
            textarea.form-control::placeholder {
                color: #94a3b8;
                font-weight: 500;
            }

            /* ===== FORM GROUP ===== */
            .form-group {
                margin-bottom: 18px !important;
            }

            /* ===== BUTTONS ===== */
            .btn {
                border-radius: 10px !important;
                font-weight: 700 !important;
                padding: 12px 24px !important;
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                border: none !important;
                font-size: 14px !important;
                text-transform: capitalize;
                letter-spacing: 0.5px;
                position: relative;
                overflow: hidden;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn::before {
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

            .btn:active::before {
                width: 300px;
                height: 300px;
            }

            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
                color: white !important;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
                width: 100%;
            }

            .btn-primary:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
                background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%) !important;
                color: white !important;
            }

            .btn-primary:active {
                transform: translateY(0) !important;
            }

            .btn-outline-secondary {
                background: white !important;
                color: #3b82f6 !important;
                border: 2px solid #3b82f6 !important;
                width: 100%;
            }

            .btn-outline-secondary:hover {
                background: linear-gradient(135deg, #f0f9ff 0%, #dbeafe 100%) !important;
                border-color: #1e40af !important;
                color: #1e40af !important;
                transform: translateY(-2px) !important;
            }

            .btn-lg {
                padding: 14px 28px !important;
                font-size: 15px !important;
            }

            .btn-link {
                color: #3b82f6 !important;
                text-decoration: none;
                font-weight: 700;
                transition: all 0.3s ease;
            }

            .btn-link:hover {
                color: #1e40af !important;
                text-decoration: underline;
            }

            /* ===== ALERTS ===== */
            .alert {
                border-radius: 10px !important;
                border: 1px solid !important;
                padding: 14px 16px !important;
                display: flex !important;
                align-items: flex-start !important;
                gap: 12px !important;
                font-weight: 500;
                margin-bottom: 18px !important;
            }

            .alert-danger {
                background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
                border-color: #fca5a5 !important;
                color: #991b1b !important;
            }

            .alert-success {
                background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%) !important;
                border-color: #86efac !important;
                color: #166534 !important;
            }

            .alert-warning {
                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
                border-color: #fcd34d !important;
                color: #92400e !important;
            }

            .alert i {
                font-size: 18px;
                margin-top: 2px;
            }

            /* ===== FORM CHECK (CHECKBOX) ===== */
            .form-check {
                margin-bottom: 12px !important;
            }

            .form-check-input {
                width: 20px !important;
                height: 20px !important;
                border: 2px solid #dbeafe !important;
                border-radius: 6px !important;
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important;
                transition: all 0.3s ease !important;
                cursor: pointer;
                margin-top: 3px;
            }

            .form-check-input:checked {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
                border-color: #1e40af !important;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            }

            .form-check-input:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            }

            .form-check-label {
                color: #1e3c72 !important;
                font-weight: 500;
                margin-left: 8px;
                cursor: pointer;
            }

            /* ===== LINKS ===== */
            a {
                color: #3b82f6;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            a:hover {
                color: #1e40af;
                text-decoration: underline;
            }

            .link-primary {
                color: #3b82f6 !important;
                font-weight: 700;
            }

            .link-primary:hover {
                color: #1e40af !important;
            }

            /* ===== TEXT STYLING ===== */
            .text-muted {
                color: #64748b !important;
                font-size: 12px;
                font-weight: 500;
            }

            small {
                color: #94a3b8 !important;
                font-weight: 500;
            }

            p {
                color: #1e3c72;
                line-height: 1.6;
            }

            /* ===== LAYOUT ===== */
            .d-grid {
                display: grid !important;
                gap: 10px;
            }

            .row {
                row-gap: 14px;
            }

            /* ===== AUTH FOOTER ===== */
            .auth-footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #dbeafe;
                text-align: center;
            }

            .auth-footer p {
                font-size: 12px;
                color: #64748b;
                margin: 0;
            }

            .auth-footer a {
                color: #3b82f6;
                font-weight: 700;
            }

            /* ===== INVALID FEEDBACK ===== */
            .invalid-feedback {
                color: #dc2626 !important;
                font-weight: 500;
                font-size: 12px;
                margin-top: 6px;
                display: block;
            }

            .is-invalid {
                border-color: #fca5a5 !important;
            }

            .is-invalid:focus {
                border-color: #dc2626 !important;
                box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1) !important;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 576px) {
                .auth-form {
                    padding: 30px 20px !important;
                }

                h2, h3 {
                    font-size: 20px !important;
                }

                .btn {
                    padding: 11px 20px !important;
                    font-size: 13px !important;
                }
            }

            /* ===== ANIMATIONS ===== */
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card {
                animation: slideIn 0.4s ease-out;
            }
        </style>

    </head>
    <!-- [Head] end -->
    <!-- [Body] Start -->

    <body>
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <div class="auth-main">
            <div class="auth-wrapper v3">
                <div class="auth-form"
                    style="background-image: url({{ asset('assets/images/my/sruni_full.jpg') }});background-size:cover;">
                    <div class="auth-header">
                        <a class="navbar-brand" href="/">
                            <img width="100" src="{{ asset('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="logo">
                        </a>
                    </div>

                    @yield('content')

                    <div class="auth-footer row">
                        <!-- <div class=""> -->
                        <div class="col my-1">
                            <p class="m-0">Copyright © <a href="#">Kopipi_121</a></p>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
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
            document.addEventListener("DOMContentLoaded", function() {

                const forms = document.querySelectorAll('form[method="post"]');

                forms.forEach(form => {
                    form.addEventListener("submit", function() {
                        const submitButton = form.querySelector('button[type="submit"]');
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Processing...";
                    });
                });
            });
        </script>

        @yield('scripts_content')

    </body>
    <!-- [Body] end -->

</html>
