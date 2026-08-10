@extends('layouts.landing')

@section('title', 'Home - Pelelangan Ikan Banyuwangi')

@push('styles')
<style>
    :root {
        --navy-900: #0f1f3d;
        --navy-800: #0d2347;
        --navy-700: #16335e;
        --navy-600: #244a85;
        --navy-accent: #f4a300;
        --navy-soft: #eef2f9;
    }

    body {
        background-color: var(--navy-soft);
    }

    /* ===== Header ===== */
    #header {
        background-color: var(--navy-900);
    }

    #header .sitename {
        color: #ffffff !important;
        font-weight: 700;
    }

    #header .navmenu ul li a {
        color: #ffffff !important;
        font-weight: 500 !important;
        transition: color .2s ease !important;
    }

    #header .navmenu ul li a:hover,
    #header .navmenu ul li a:focus,
    #header .navmenu ul li a.active {
        color: var(--navy-accent) !important;
    }

    #header .mobile-nav-toggle {
        color: #fff !important;
    }

    /* ===== About / Hero ===== */
    .about .section-subtitle {
        color: var(--navy-accent);
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .9rem;
    }

    .about h1 {
        color: var(--navy-900);
        font-weight: 800;
    }

    .about p {
        color: #4a5568;
    }

    .btn-get-started {
        background-color: var(--navy-700) !important;
        color: #fff !important;
        border: none;
        padding: .75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: background-color .2s ease, transform .2s ease;
        display: inline-block;
    }

    .btn-get-started:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        transform: translateY(-2px);
    }

    /* ===== Search Section ===== */
    .search-lelang {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 100%);
        padding: 50px 0;
    }

    .search-lelang .search-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(7, 20, 43, .25);
    }

    .search-lelang h2 {
        color: #fff;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }

    .search-lelang .form-control {
        border: 1px solid #cdd6e4;
        border-radius: 50px 0 0 50px;
        padding: .75rem 1.25rem;
        box-shadow: none;
    }

    .search-lelang .form-control:focus {
        border-color: var(--navy-600);
        box-shadow: 0 0 0 3px rgba(36, 74, 133, .15);
    }

    .search-lelang .btn-search {
        background-color: var(--navy-700);
        border: 1px solid var(--navy-700);
        color: #fff;
        border-radius: 0 50px 50px 0;
        padding: .75rem 1.75rem;
        font-weight: 600;
        transition: background-color .2s ease;
    }

    .search-lelang .btn-search:hover {
        background-color: var(--navy-accent);
        border-color: var(--navy-accent);
        color: var(--navy-900);
    }

    .search-lelang .btn-reset {
        border-radius: 50px;
        color: #172e57;
        text-decoration: underline;
        font-size: .9rem;
        display: inline-block;
        margin-top: 12px;
    }

    .search-lelang .btn-reset:hover {
        color: var(--navy-accent);
    }

    /* ===== Lelang Cards Section ===== */
    .lelang-section {
        padding: 60px 0;
    }

    .lelang-section .section-title h2 {
        color: var(--navy-900);
        font-weight: 800;
    }

    .lelang-section .section-title p {
        color: #6b7785;
    }

    .lelang-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .08);
        transition: transform .25s ease, box-shadow .25s ease;
        height: 100%;
    }

    .lelang-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(7, 20, 43, .15);
    }

    .lelang-card .lelang-img {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .lelang-card .lelang-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lelang-card .badge-status {
        position: absolute;
        top: 12px;
        left: 12px;
        background-color: var(--navy-accent);
        color: var(--navy-900);
        font-weight: 700;
        font-size: .75rem;
        padding: 5px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .lelang-card .lelang-body {
        padding: 18px 20px;
    }

    .lelang-card h3 {
        color: var(--navy-900);
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .lelang-card .lelang-meta {
        display: flex;
        justify-content: space-between;
        font-size: .9rem;
        color: #6b7785;
        margin-bottom: 12px;
    }

    .lelang-card .lelang-meta strong {
        color: var(--navy-700);
    }

    .lelang-card .tpi-name {
        font-size: .85rem;
        color: #9aa5b1;
        margin-bottom: 12px;
    }

    .lelang-card .btn-detail {
        background-color: var(--navy-900);
        color: #fff;
        border-radius: 50px;
        padding: .5rem 1.25rem;
        font-size: .9rem;
        font-weight: 600;
        display: inline-block;
        transition: background-color .2s ease;
    }

    .lelang-card .btn-detail:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6b7785;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--navy-600);
        margin-bottom: 15px;
        display: block;
    }

    /* ===== How It Works Section ===== */
    .how-it-works {
        padding: 70px 0;
        background-color: #fff;
    }

    .how-it-works .section-title h2 {
        color: var(--navy-900);
        font-weight: 800;
    }

    .how-it-works .section-title p {
        color: #6b7785;
    }

    .how-it-works .step-card {
        text-align: center;
        padding: 35px 25px;
        border-radius: 14px;
        background-color: var(--navy-soft);
        height: 100%;
        transition: transform .25s ease, box-shadow .25s ease;
        position: relative;
    }

    .how-it-works .step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(7, 20, 43, .1);
    }

    .how-it-works .step-number {
        width: 56px;
        height: 56px;
        line-height: 56px;
        border-radius: 50%;
        background-color: var(--navy-700);
        color: #fff;
        font-weight: 800;
        font-size: 1.25rem;
        margin: 0 auto 20px auto;
    }

    .how-it-works .step-card .step-icon {
        font-size: 2.5rem;
        color: var(--navy-accent);
        margin-bottom: 15px;
        display: block;
    }

    .how-it-works .step-card h3 {
        color: var(--navy-900);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .how-it-works .step-card p {
        color: #6b7785;
        font-size: .95rem;
        margin-bottom: 0;
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

    /* ===== Responsive tweaks ===== */
    @media (max-width: 768px) {
        .search-lelang .form-control {
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .search-lelang .btn-search {
            border-radius: 12px;
            width: 100%;
        }

        .search-lelang .search-card {
            padding: 20px;
        }

        .lelang-card .lelang-img {
            height: 180px;
        }

        .how-it-works .step-card {
            margin-bottom: 20px;
        }
    }
    
    @media (min-width: 992px) {
        .col-lg-2-4 {
            flex: 0 0 auto;
            width: 20%;
        }
    }
</style>
@endpush

@section('content')

<!-- About Section -->
<section id="about" class="about section">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2" data-aos="fade-up" data-aos-delay="400">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true
                            , "speed": 600
                            , "autoplay": {
                                "delay": 5000
                            }
                            , "slidesPerView": "auto"
                            , "pagination": {
                                "el": ".swiper-pagination"
                                , "type": "bullets"
                                , "clickable": true
                            }
                            , "breakpoints": {
                                "320": {
                                    "slidesPerView": 1
                                    , "spaceBetween": 40
                                }
                                , "1200": {
                                    "slidesPerView": 1
                                    , "spaceBetween": 1
                                }
                            }
                        }
                    </script>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/img/laut 4.jpg') }}" alt="Image" class="img-fluid">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/img/laut 5.jpg') }}" alt="Image" class="img-fluid">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/img/laut 6.jpg') }}" alt="Image" class="img-fluid">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-4 order-lg-1">
                <span class="section-subtitle" data-aos="fade-up">Selamat datang di Pelangi</span>
                <h1 class="mb-4" data-aos="fade-up">
                    Pusat Pelelangan ikan Banyuwangi
                </h1>
                <p data-aos="fade-up">
                    Pusat pelelangan ikan Banyuwangi, gerbang utama menuju
                    kelimpahan hasil laut dari perairan Banyuwangi yang kaya, tempat transaksi cepat
                    dan transparan mempertemukan nelayan dan pembeli, menghadirkan ikan segar berkualitas
                    tinggi dengan harga bersaing, langsung dari nelayan terpercaya, baik secara langsung
                    maupun melalui platform digital yang efisien, untuk memperkuat ekonomi lokal dan
                    mendukung keberlanjutan perikanan.
                </p>
                <p class="mt-5" data-aos="fade-up">
                    <a href="{{ route('register') }}" class="btn btn-get-started">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</section><!-- /About Section -->

<!-- Search Lelang Section -->
<section id="search-lelang" class="search-lelang">
    <div class="container">
        <h2 data-aos="fade-up">Cari Lelang Ikan</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-card" data-aos="fade-up" data-aos-delay="100">
                    <form action="{{ route('landingpage') }}#search-lelang" method="GET">
                        <div class="input-group">
                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Cari jenis ikan, contoh: Tuna, Kakap..."
                                value="{{ $keyword ?? '' }}">
                            <button type="submit" class="btn btn-search">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>
                    @if($searched ?? false)
                        <div class="text-center">
                            <a href="{{ route('landingpage') }}#search-lelang" class="btn-reset">
                                <i class="bi bi-x-circle"></i> Hapus pencarian
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section><!-- /Search Lelang Section -->

<!-- Lelang Section -->
<section id="lelang" class="lelang-section">
    <div class="container section-title" data-aos="fade-up">
        @if($searched ?? false)
            <h2>Hasil Pencarian "{{ $keyword }}"</h2>
            <p>{{ $produk->count() }} lelang ditemukan</p>
        @else
            <h2>Lelang Terbaru</h2>
            <p>Lelang ikan yang sedang berlangsung saat ini</p>
        @endif
    </div>

    <div class="container">
        @if($produk->isEmpty())
            <div class="empty-state" data-aos="fade-up">
                <i class="bi bi-emoji-frown"></i>
                @if($searched ?? false)
                    <p>Tidak ada lelang yang cocok dengan pencarian "{{ $keyword }}".</p>
                @else
                    <p>Belum ada lelang yang sedang berlangsung saat ini.</p>
                @endif
            </div>
        @else
            <div class="row gy-4">
                @foreach($produk as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="lelang-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="lelang-img">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->jenis_ikan }}">
                                @else
                                    <img src="{{ asset('assets/img/ikan 1.jpg') }}" alt="{{ $item->jenis_ikan }}">
                                @endif
                                <span class="badge-status">Berlangsung</span>
                            </div>
                            <div class="lelang-body">
                                <h3>{{ $item->jenis_ikan }}</h3>
                                <div class="lelang-meta">
                                    <span>Berat: <strong>{{ $item->berat }} kg</strong></span>
                                    <span>Harga awal: <strong>Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</strong></span>
                                </div>
                                @if($item->tpi)
                                    <div class="tpi-name">
                                        <i class="bi bi-geo-alt"></i> {{ $item->tpi->name ?? 'TPI' }}
                                    </div>
                                @endif
                                <a href="{{ route('login') }}" class="btn-detail">
                                    Lihat Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section><!-- /Lelang Section -->

<!-- How It Works Section -->
<section id="how-it-works" class="how-it-works">
    <div class="container section-title" data-aos="fade-up">
        <h2>Alur Lelang</h2>
        <p>Ikuti langkah mudah berikut untuk mulai bertransaksi di Pelangi</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6 col-lg-2-4">
                <div class="step-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">1</div>
                    <i class="bi bi-person-plus step-icon"></i>
                    <h3>Daftar Akun</h3>
                    <p>Buat akun secara gratis sebagai pembeli atau nelayan untuk mulai mengakses fitur lelang.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-2-4">
                <div class="step-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-number">2</div>
                    <i class="bi bi-search step-icon"></i>
                    <h3>Pilih Lelang</h3>
                    <p>Jelajahi daftar lelang ikan segar yang sedang berlangsung dan pilih sesuai kebutuhan Anda.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-2-4">
                <div class="step-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">3</div>
                    <i class="bi bi-hammer step-icon"></i>
                    <h3>Ikuti Penawaran</h3>
                    <p>Pasang penawaran terbaik Anda secara real-time dan pantau status lelang hingga berakhir.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-2-4">
                <div class="step-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-number">4</div>
                    <i class="bi bi-cash-coin step-icon"></i>
                    <h3>Lakukan Pembayaran</h3>
                    <p>Pemenang lelang melakukan pembayaran secara online dan mendapatkan struk bukti pembayaran.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-2-4">
                <div class="step-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-number">5</div>
                    <i class="bi bi-box-seam step-icon"></i>
                    <h3>Ambil Ikan</h3>
                    <p>Tunjukkan struk bukti pembayaran untuk pengambilan ikan di Tempat Pelelangan Ikan (TPI)</p>
                </div>
            </div>
        </div>
    </div>
</section><!-- /How It Works Section -->

@endsection