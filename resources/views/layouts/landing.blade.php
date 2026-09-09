<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'PELUANG - Pelelangan Ikan Terpadu Cemerlang')</title>
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">

    <!-- PWA Manifest, theme-color, apple-touch-icon (auto dari package silviolleite/laravelpwa) -->
    @laravelPWA

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
                <h1 class="sitename">Peluang</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('landingpage') }}" class="{{ request()->routeIs('landingpage') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a></li>
                    <li><a href="{{ route('tpi.cari-terdekat') }}" class="{{ request()->routeIs('tpi.cari-terdekat') ? 'active' : '' }}">Cari TPI</a></li>
                    <a></a>
                    <li><a href="{{ route('register') }}" class="btn-nav btn-nav-outline {{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a></li>
                    <a></a>
                    <li><a href="{{ route('login') }}" class="btn-nav btn-nav-fill {{ request()->routeIs('login') ? 'active' : '' }}">Login</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container">
            <div class="row g-4">

                <!-- Brand & Description -->
                <div class="col-lg-4 col-md-6">
                    <div class="widget">
                        <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center mb-3">
                            <h1 class="sitename" style="color:#fff; font-size:24px;">Peluang</h1>
                        </a>
                        <p>
                            Platform pelelangan ikan digital yang menghubungkan nelayan dan pembeli
                            secara cepat, transparan, dan terpercaya, demi mendukung ekonomi lokal
                            dan keberlanjutan perikanan Nasional.
                        </p>
                        <ul class="list-unstyled social-icons light mb-0">
                            <li><a href="#"><span class="bi bi-facebook"></span></a></li>
                            <li><a href="#"><span class="bi bi-twitter-x"></span></a></li>
                            <li><a href="#"><span class="bi bi-instagram"></span></a></li>
                            <li><a href="#"><span class="bi bi-linkedin"></span></a></li>
                            <li><a href="#"><span class="bi bi-google-play"></span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="widget">
                        <h3 class="widget-heading">Tautan</h3>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('landingpage') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('contact') }}">Kontak</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Account Links -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <h3 class="widget-heading">Akun</h3>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Daftar Akun</a></li>
                            <li><a href="#">Syarat & Ketentuan</a></li>
                            <li><a href="#">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <h3 class="widget-heading">Hubungi Kami</h3>
                        <ul class="list-unstyled footer-contact">
                            <li class="d-flex mb-2">
                                <i class="bi bi-geo-alt me-2"></i>
                                <span>Pelabuhan Perikanan, Banyuwangi, Jawa Timur</span>
                            </li>
                            <li class="d-flex mb-2">
                                <i class="bi bi-envelope me-2"></i>
                                <span>info@peluang-banyuwangi.id</span>
                            </li>
                            <li class="d-flex mb-2">
                                <i class="bi bi-telephone me-2"></i>
                                <span>+62 812-3456-7890</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="copyright text-center">
                <p>&copy; {{ date('Y') }} <strong>Peluang</strong>. Pusat Pelelangan Ikan Terpadu Cemerlang. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')

</body>

</html>