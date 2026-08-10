@extends('layouts.landing')

@section('title', 'About - Pelelangan Ikan Banyuwangi')
@section('description', 'Tentang Pusat Pelelangan Ikan Banyuwangi (PELANGI) - Kerjasama dengan TPI Muncar dan Dinas Perikanan')
@push('styles')
<style>
    :root {
        --navy-900: #0f1f3d;
        --navy-800: #0d2347;
        --navy-700: #16335e;
        --navy-600: #244a85;
        --navy-accent: #f4a300;
        --navy-soft: #eef2f9;
        --navy-text-muted: #6b7785;
    }

    body {
        background-color: var(--navy-soft);
    }

    /* ===== Header ===== */
    #header {
        background-color: var(--navy-900);
    }

    #header .sitename {
        color: #fff;
        font-weight: 700;
    }

    #header .navmenu ul li a {
        color: #ffffff;
        font-weight: 500;
        transition: color .2s ease;
    }

    #header .navmenu ul li a:hover,
    #header .navmenu ul li a:focus,
    #header .navmenu ul li a.active {
        color: var(--navy-accent) !important;
    }

    #header .mobile-nav-toggle {
        color: #fff;
    }

    /* ===== Page Title ===== */
    .page-title.light-background {
        background-color: var(--navy-900) !important;
        padding: 40px 0;
    }

    .page-title h1 {
        color: #fff;
        font-weight: 800;
        font-size: 28px;
    }

    .page-title .breadcrumbs ol li a {
        color: #c3cde0;
    }

    .page-title .breadcrumbs ol li a:hover {
        color: var(--navy-accent);
    }

    .page-title .breadcrumbs ol li.current {
        color: var(--navy-accent);
        font-weight: 600;
    }

    .page-title .breadcrumbs ol li+li::before {
        color: #c3cde0;
    }

    /* ===== About 2 Section ===== */
    .about-2 .content {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .06);
    }

    .about-2 .img-wrap .img {
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(7, 20, 43, .15);
    }

    .about-2 .section-subtitle {
        color: var(--navy-accent);
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .9rem;
    }

    .about-2 .content-title {
        color: var(--navy-900);
        font-weight: 800;
    }

    .about-2 .lead {
        color: #4a5568;
    }

    .about-2 p {
        color: var(--navy-text-muted);
    }

    .about-2 .btn-get-started {
        background-color: var(--navy-700);
        color: #fff;
        border: none;
        padding: .75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: background-color .2s ease, transform .2s ease;
        display: inline-block;
    }

    .about-2 .btn-get-started:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        transform: translateY(-2px);
    }

    /* ===== Services Section ===== */
    .services .section-title h2 {
        color: var(--navy-900);
        font-weight: 800;
    }

    .services .section-title p,
    .services .section-subtitle {
        color: var(--navy-text-muted);
    }

    .services .section-subtitle {
        color: var(--navy-accent);
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .9rem;
        display: block;
    }

    .services-item {
        display: flex;
        gap: 18px;
        background: #fff;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .08);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .services-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(7, 20, 43, .15);
    }

    .services-item .services-icon i {
        font-size: 2.2rem;
        color: var(--navy-accent);
    }

    .services-item h3 {
        color: var(--navy-900);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .services-item p {
        color: var(--navy-text-muted);
        font-size: .95rem;
        margin-bottom: 0;
    }

    /* ===== Stats / Kerjasama Section ===== */
    .stats {
        background-color: #fff;
    }

    .stats .images-overlap img {
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(7, 20, 43, .15);
        width: 100%;
    }

    .stats .section-subtitle {
        color: var(--navy-accent);
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .9rem;
        display: block;
    }

    .stats .content-title {
        color: var(--navy-900);
        font-weight: 800;
    }

    .stats .lead {
        color: #4a5568;
    }

    .stats p {
        color: var(--navy-text-muted);
    }

    .stats .count-numbers .number {
        color: var(--navy-900);
        font-weight: 800;
        font-size: 1.8rem;
    }

    .stats .count-numbers .number:after {
        background: var(--navy-accent);
    }

    .stats .count-numbers span.d-block {
        color: var(--navy-text-muted);
        font-size: .9rem;
    }

    /* ===== Program / How Cards Section ===== */
    .how-it-works {
        padding: 70px 0;
        background-color: var(--navy-soft);
    }

    .how-it-works .section-title h2 {
        color: var(--navy-900);
        font-weight: 800;
    }

    .how-it-works .section-title p {
        color: var(--navy-text-muted);
    }

    .how-it-works .section-subtitle {
        color: var(--navy-accent);
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .9rem;
        display: block;
    }

    .how-card {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .08);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .how-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(7, 20, 43, .12);
    }

    .how-icon {
        width: 56px;
        height: 56px;
        line-height: 56px;
        text-align: center;
        border-radius: 50%;
        background-color: var(--navy-700);
        color: #fff;
        font-size: 1.5rem;
        margin-bottom: 18px;
    }

    .how-card h3 {
        color: var(--navy-900);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .how-card p {
        color: var(--navy-text-muted);
        font-size: .95rem;
        margin-bottom: 0;
    }

    /* ===== CTA Section ===== */
    .cta-section {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 100%);
        padding: 60px 0;
        text-align: center;
    }

    .cta-section h2 {
        color: #fff;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .cta-section p {
        color: #c3cde0;
        margin-bottom: 25px;
    }

    .cta-section .btn-get-started {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        border: none;
        padding: .75rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        transition: transform .2s ease;
        display: inline-block;
    }

    .cta-section .btn-get-started:hover {
        transform: translateY(-2px);
        color: var(--navy-900);
    }

    /* ===== Footer ===== */
    .footer.light-background {
        background-color: var(--navy-900) !important;
        color: #e6ecf7;
    }

    .footer .widget-heading {
        color: #fff;
    }

    .footer p,
    .footer span {
        color: #c3cde0;
    }

    .footer .widget ul li a {
        color: #c3cde0;
    }

    .footer .widget ul li a:hover {
        color: var(--navy-accent) !important;
    }

    .footer .footer-contact i {
        color: var(--navy-accent);
    }

    .footer .social-icons.light a {
        color: #e6ecf7;
        border: 1px solid rgba(255, 255, 255, .2);
    }

    .footer .social-icons.light a:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        border-color: var(--navy-accent);
    }

    .footer .copyright {
        border-top: 1px solid rgba(255, 255, 255, .1);
        margin-top: 40px;
        padding-top: 20px;
    }

    .footer .copyright p {
        color: #c3cde0;
        margin: 0;
        font-size: .9rem;
    }
</style>
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <h1>About Pelangi</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('landingpage') }}">Home</a></li>
                    <li class="current">About</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- About 2 Section -->
    <section id="about-2" class="about-2 section">
        <div class="container">
            <div class="content">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-12 col-md-5 col-lg-4 col-xl-4 order-lg-2 offset-xl-1 mb-4">
                        <div class="img-wrap text-center text-md-left" data-aos="fade-up" data-aos-delay="100">
                            <div class="img">
                                <img src="{{ asset('assets/img/laut 5.jpg') }}" alt="Pemandangan laut Banyuwangi" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="offset-md-0 offset-lg-1 col-sm-12 col-md-5 col-lg-5 col-xl-4" data-aos="fade-up">
                        <div class="px-3">
                            <span class="section-subtitle">Misi Kami</span>
                            <h2 class="content-title">
                                Menghubungkan Nelayan dan Pembeli dengan Teknologi Modern
                            </h2>
                            <p class="lead">
                                PELANGI (Pelelangan Ikan Banyuwangi) adalah platform digital yang menghubungkan nelayan lokal dengan pembeli secara efisien dan transparan.
                            </p>
                            <p class="mb-4">
                                Bekerja sama dengan Dinas Perikanan Banyuwangi, kami berkomitmen untuk mendukung perekonomian nelayan lokal dan memastikan keberlanjutan hasil laut Banyuwangi.
                            </p>
                            <a href="{{ route('register') }}" class="btn-get-started">Bergabung Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /About 2 Section -->

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container section-title" data-aos="fade-up">
            <span class="section-subtitle">Keunggulan</span>
            <h2>Mengapa Memilih Pelangi</h2>
            <p>Tiga nilai utama yang menjadi landasan setiap transaksi di platform kami.</p>
        </div>
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="services-item h-100" data-aos="fade-up" data-aos-delay="100">
                        <div class="services-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h3>Kesegaran Terjamin</h3>
                            <p>Ikan langsung dari nelayan ke pembeli, memastikan kualitas dan kesegaran terbaik untuk setiap produk.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="services-item h-100" data-aos="fade-up" data-aos-delay="200">
                        <div class="services-icon">
                            <i class="bi bi-currency-exchange"></i>
                        </div>
                        <div>
                            <h3>Transaksi Transparan</h3>
                            <p>Sistem lelang yang adil dan terbuka untuk nelayan dan pembeli dengan harga yang kompetitif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="services-item h-100" data-aos="fade-up" data-aos-delay="300">
                        <div class="services-icon">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div>
                            <h3>Keberlanjutan</h3>
                            <p>Mendukung praktik penangkapan ikan yang bertanggung jawab untuk kelestarian sumber daya laut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Services Section -->

    <!-- Kerjasama / Stats Section -->
    <section id="stats" class="stats section">
        <div class="container">
            <div class="row gy-4 justify-content-center align-items-center">
                <div class="col-lg-5">
                    <div class="images-overlap" data-aos="fade-up">
                        <img src="{{ asset('assets/img/laut 4.jpg') }}" alt="Kegiatan di TPI Muncar" class="img-fluid img-1">
                    </div>
                </div>
                <div class="col-lg-4 ps-lg-5" data-aos="fade-up">
                    <span class="section-subtitle">Kerjasama</span>
                    <h2 class="content-title">Kolaborasi untuk Memperkuat Ekonomi Maritim</h2>
                    <p class="lead">
                        PELANGI adalah hasil kerjasama antara TPI Muncar dan Dinas Perikanan Kabupaten Banyuwangi.
                    </p>
                    <p class="mb-4">
                        Dengan menggabungkan pengalaman TPI dalam pengelolaan lelang tradisional dan pengawasan Dinas Perikanan, kami menghadirkan solusi digital yang memenuhi kebutuhan pasar modern sekaligus menjaga nilai-nilai tradisional.
                    </p>
                    <div class="row count-numbers">
                        <div class="col-4 counter" data-aos="fade-up" data-aos-delay="100">
                            <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter number"></span>
                            <span class="d-block">Nelayan</span>
                        </div>
                        <div class="col-4 counter" data-aos="fade-up" data-aos-delay="200">
                            <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter number"></span>
                            <span class="d-block">Pembeli</span>
                        </div>
                        <div class="col-4 counter" data-aos="fade-up" data-aos-delay="300">
                            <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter number"></span>
                            <span class="d-block">Transaksi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Kerjasama Section -->

    <!-- Program Section -->
    <section id="programs" class="how-it-works">
        <div class="container section-title" data-aos="fade-up">
            <span class="section-subtitle">Komitmen Kami</span>
            <h2>Program Keberlanjutan</h2>
            <p>PELANGI berkomitmen mendukung praktik perikanan yang berkelanjutan melalui berbagai program berikut.</p>
        </div>
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-md-6 col-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="how-card text-start h-100">
                        <div class="how-icon"><i class="bi bi-patch-check"></i></div>
                        <h3>Sertifikasi Produk</h3>
                        <p>Kerjasama dengan lembaga sertifikasi untuk menjamin kualitas dan keberlanjutan hasil laut yang dijual.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="how-card text-start h-100">
                        <div class="how-icon"><i class="bi bi-recycle"></i></div>
                        <h3>Pengurangan Limbah</h3>
                        <p>Inisiatif untuk mengurangi limbah plastik dalam proses pelelangan dan distribusi ikan.</p>
                    </div>
                </div>
                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="300">
                    <p class="text-center mt-3 mb-0" style="color: var(--navy-text-muted);">
                        Dengan menggabungkan teknologi modern dan nilai-nilai keberlanjutan, PELANGI bertujuan menciptakan ekosistem perikanan yang menguntungkan bagi semua pihak dan berkelanjutan untuk generasi mendatang.
                    </p>
                </div>
            </div>
        </div>
    </section><!-- /Program Section -->

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container" data-aos="fade-up">
            <h2>Mari Bergabung dengan PELANGI</h2>
            <p>Jadi bagian dari ekosistem pelelangan ikan digital yang transparan dan berkelanjutan.</p>
            <a href="{{ route('register') }}" class="btn-get-started">Daftar Sekarang</a>
        </div>
    </section><!-- /CTA Section -->

@endsection