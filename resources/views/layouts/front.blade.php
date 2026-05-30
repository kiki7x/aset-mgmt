<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('ppl-icon.png') }}" rel="icon">
    <link href="{{ asset('arsha/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}
    {{-- pakai font poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files (preload critical styles to avoid FOUC) -->
    <link rel="preload" as="style" href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" onload="this.rel='stylesheet'">
    {{-- <link href="{{ asset('arsha/assets/vendor/aos/aos.css') }}" rel="stylesheet"> --}}
    <link rel="preload" as="style" href="{{ asset('arsha/assets/vendor/glightbox/css/glightbox.min.css') }}" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" href="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.css') }}" onload="this.rel='stylesheet'">
    <!-- Template Main CSS File (preload + onload swap) -->
    <link rel="preload" as="style" href="{{ asset('arsha/assets/css/main.css') }}" onload="this.rel='stylesheet'">
    <!-- Font Awesome -->
    <link rel="preload" as="style" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" onload="this.rel='stylesheet'">
    <noscript>
        <link href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('arsha/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('arsha/assets/css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    </noscript>

    <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

    {{-- script tambahan --}}
    @stack('script-head')
    {{-- ./script tambahan --}}
    <!-- Prevent flash of unstyled content (FOUC) while CSS loads -->
    <style>
        /* Hide page until fully loaded to avoid FOUC */
        body.front-loading {
            visibility: hidden;
        }

        /* Simple preloader style (minimal) */
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 99999;
        }

        #preloader .spinner {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: #444;
        }
    </style>

    <noscript>
        <style>
            /* If JS is disabled, show the page and hide preloader */
            body.front-loading {
                visibility: visible;
            }

            #preloader {
                display: none;
            }
        </style>
    </noscript>

</head>

<body class="front-loading index-page">
    <x-frontsite.header></x-frontsite.header>
    @yield('content')
    <x-frontsite.footer></x-frontsite.footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('arsha/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('arsha/assets/vendor/aos/aos.js') }}"></script> --}}
    <script src="{{ asset('arsha/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('arsha/assets/js/main.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    {{-- <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    {{-- Datatables --}}
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>


    {{-- script tambahan --}}
    @stack('script-foot')
    {{-- ./script tambahan --}}

    <script>
        // Remove preloader and reveal page when all resources are loaded.
        (function() {
            function finish() {
                try {
                    document.body.classList.remove('front-loading');
                    var p = document.getElementById('preloader');
                    if (p) {
                        p.style.display = 'none';
                    }
                } catch (e) {
                    /* ignore */ }
            }
            if (document.readyState === 'complete') {
                finish();
            } else {
                window.addEventListener('load', finish);
                // Fallback: reveal after 2.5s in case load doesn't fire timely
                setTimeout(finish, 2500);
            }
        })();
    </script>
</body>

</html>
