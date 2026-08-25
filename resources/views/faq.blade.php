@extends('layouts.landing')

@section('title', 'FAQ - Pelelangan Ikan Terpadu Cemerlang')

@push('styles')
<style>
    :root {
        --navy-900: #0f1f3d;
        --navy-800: #0f1f3d;
        --navy-700: #0f1f3d;
        --navy-600: #0f1f3d;
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

    /* ===== Page Title ===== */
    .page-title {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 100%);
        padding: 50px 0 40px;
        margin-bottom: 0;
    }

    .page-title h1 {
        color: #fff;
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .page-title .breadcrumbs ol {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
        align-items: center;
    }

    .page-title .breadcrumbs ol li {
        color: #c3cde0;
        font-size: .9rem;
    }

    .page-title .breadcrumbs ol li a {
        color: #c3cde0;
        text-decoration: none;
        transition: color .2s ease;
    }

    .page-title .breadcrumbs ol li a:hover {
        color: #fff;
    }

    .page-title .breadcrumbs ol li.current {
        color: #f4a300;
    }

    .page-title .breadcrumbs ol li + li::before {
        content: '/';
        margin-right: 8px;
        color: #7a90b0;
    }

    /* ===== FAQ Section ===== */
    .faq-section {
        padding: 70px 0;
    }

    .faq-section .section-title h2 {
        color: var(--navy-900);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .faq-section .section-title p {
        color: #6b7785;
    }

    /* Accordion */
    .faq-accordion .accordion-item {
        background: #fff;
        border: none;
        border-radius: 12px !important;
        margin-bottom: 14px;
        box-shadow: 0 4px 14px rgba(7, 20, 43, .08);
        overflow: hidden;
        transition: box-shadow .25s ease;
    }

    .faq-accordion .accordion-item:hover {
        box-shadow: 0 8px 22px rgba(7, 20, 43, .14);
    }

    .faq-accordion .accordion-button {
        background-color: #fff;
        color: var(--navy-900);
        font-weight: 600;
        font-size: 1rem;
        padding: 20px 24px;
        border-radius: 12px !important;
        box-shadow: none !important;
        transition: background-color .2s ease, color .2s ease;
    }

    .faq-accordion .accordion-button:not(.collapsed) {
        background-color: var(--navy-900);
        color: #fff;
        border-radius: 12px 12px 0 0 !important;
    }

    .faq-accordion .accordion-button::after {
        filter: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23172e57'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .faq-accordion .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .faq-accordion .accordion-body {
        padding: 20px 24px 24px;
        color: #4a5568;
        font-size: .95rem;
        line-height: 1.7;
        border-top: 1px solid #e8edf5;
    }

    /* Number badge on each item */
    .faq-accordion .accordion-button .faq-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--navy-soft);
        color: var(--navy-700);
        font-size: .8rem;
        font-weight: 700;
        margin-right: 14px;
        flex-shrink: 0;
        transition: background-color .2s ease, color .2s ease;
    }

    .faq-accordion .accordion-button:not(.collapsed) .faq-number {
        background-color: var(--navy-accent);
        color: var(--navy-900);
    }

    /* ===== CTA Banner ===== */
    .faq-cta {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 100%);
        border-radius: 16px;
        padding: 45px 35px;
        text-align: center;
        margin-top: 50px;
        box-shadow: 0 10px 30px rgba(7, 20, 43, .2);
    }

    .faq-cta h3 {
        color: #fff;
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 10px;
    }

    .faq-cta p {
        color: #c3cde0;
        margin-bottom: 25px;
    }

    .faq-cta .btn-cta {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        border: none;
        padding: .75rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        display: inline-block;
        transition: background-color .2s ease, transform .2s ease;
        margin: 6px;
        text-decoration: none;
    }

    .faq-cta .btn-cta:hover {
        background-color: #e09500;
        transform: translateY(-2px);
    }

    .faq-cta .btn-outline-cta {
        background-color: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,.4);
        padding: .7rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        display: inline-block;
        transition: border-color .2s ease, background-color .2s ease, transform .2s ease;
        margin: 6px;
        text-decoration: none;
    }

    .faq-cta .btn-outline-cta:hover {
        border-color: var(--navy-accent);
        background-color: rgba(244,163,0,.1);
        transform: translateY(-2px);
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

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .page-title h1 {
            font-size: 1.6rem;
        }

        .faq-cta {
            padding: 30px 20px;
        }

        .faq-accordion .accordion-button {
            font-size: .95rem;
            padding: 16px 18px;
        }

        .faq-accordion .accordion-body {
            padding: 16px 18px 20px;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Title --}}
<div class="page-title light-background">
    <div class="container">
        <h1>FAQ Pelangi</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('landingpage') }}">Home</a></li>
                <li class="current">FAQ</li>
            </ol>
        </nav>
    </div>
</div>

{{-- FAQ Section --}}
<section id="faq" class="faq-section">
    <div class="container section-title text-center mb-5" data-aos="fade-up">
        <h2>Pertanyaan yang Sering Diajukan</h2>
        <p>Temukan jawaban atas pertanyaan umum seputar platform PELANGI</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="accordion faq-accordion" id="accordionFaq">

                    {{-- Item 1 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse1"
                                aria-expanded="true" aria-controls="faqCollapse1">
                                <span class="faq-number">1</span>
                                Apa itu PELANGI?
                            </button>
                        </h2>
                        <div id="faqCollapse1" class="accordion-collapse collapse show"
                            aria-labelledby="faqHeading1" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                PELANGI adalah singkatan dari <strong>Pelelangan Ikan Terpadu Cemerlang</strong>,
                                sebuah platform online yang menghubungkan nelayan, penjual ikan, dan pembeli
                                dalam satu sistem pelelangan ikan digital yang terpercaya di wilayah Banyuwangi.
                            </div>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse2"
                                aria-expanded="false" aria-controls="faqCollapse2">
                                <span class="faq-number">2</span>
                                Bagaimana cara untuk mengikuti lelang?
                            </button>
                        </h2>
                        <div id="faqCollapse2" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading2" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Setelah melakukan login, masuk ke menu <strong>"Lelang"</strong> untuk melihat semua
                                lelang yang sedang berlangsung. Pilih lelang yang Anda minati, lihat detail dan foto
                                ikannya, kemudian masukkan penawaran Anda.
                            </div>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse3"
                                aria-expanded="false" aria-controls="faqCollapse3">
                                <span class="faq-number">3</span>
                                Apa yang terjadi jika saya memenangkan lelang?
                            </button>
                        </h2>
                        <div id="faqCollapse3" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading3" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Jika Anda memenangkan lelang, Anda akan mendapatkan <strong>notifikasi</strong>
                                dengan instruksi pembayaran dan pengambilan ikan secara langsung di TPI terkait.
                            </div>
                        </div>
                    </div>

                    {{-- Item 4 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse4"
                                aria-expanded="false" aria-controls="faqCollapse4">
                                <span class="faq-number">4</span>
                                Apakah penawaran bisa dibatalkan?
                            </button>
                        </h2>
                        <div id="faqCollapse4" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading4" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Demi menjaga integritas sistem lelang kami, <strong>penawaran yang sudah diajukan
                                tidak bisa dibatalkan</strong>. Pastikan Anda yakin sebelum memasukkan jumlah penawaran.
                            </div>
                        </div>
                    </div>

                    {{-- Item 5 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse5"
                                aria-expanded="false" aria-controls="faqCollapse5">
                                <span class="faq-number">5</span>
                                Bagaimana cara mendaftar di PELANGI?
                            </button>
                        </h2>
                        <div id="faqCollapse5" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading5" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Cukup klik tombol <strong>"Daftar"</strong> di pojok kanan atas halaman utama,
                                isi formulir data diri Anda, verifikasi email, dan akun Anda siap digunakan.
                            </div>
                        </div>
                    </div>

                    {{-- Item 6 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading6">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse6"
                                aria-expanded="false" aria-controls="faqCollapse6">
                                <span class="faq-number">6</span>
                                Jika lupa kata sandi, bagaimana cara meresetnya?
                            </button>
                        </h2>
                        <div id="faqCollapse6" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading6" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Pada halaman login klik <strong>"Lupa Password"</strong>, lalu masukkan email yang
                                terdaftar dan Anda akan menerima tautan untuk mengatur ulang kata sandi.
                                Jika email tidak masuk dalam 5 menit, periksa folder <em>spam</em>.
                            </div>
                        </div>
                    </div>

                    {{-- Item 7 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading7">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse7"
                                aria-expanded="false" aria-controls="faqCollapse7">
                                <span class="faq-number">7</span>
                                Kenapa akun saya belum diverifikasi padahal sudah menunggu beberapa hari?
                            </button>
                        </h2>
                        <div id="faqCollapse7" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading7" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Proses verifikasi biasanya memakan waktu <strong>1–2 hari kerja</strong>.
                                Jika sudah lebih dari waktu tersebut, kemungkinan ada dokumen yang kurang jelas
                                atau informasi yang perlu dilengkapi. Hubungi tim kami melalui halaman Contact.
                            </div>
                        </div>
                    </div>

                    {{-- Item 8 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading8">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse8"
                                aria-expanded="false" aria-controls="faqCollapse8">
                                <span class="faq-number">8</span>
                                Bagaimana jika saya mengalami masalah teknis saat menggunakan platform?
                            </button>
                        </h2>
                        <div id="faqCollapse8" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading8" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Kunjungi halaman <strong>FAQ</strong> atau <strong>Contact</strong> untuk
                                melaporkan masalah Anda. Tim kami akan segera membantu menyelesaikannya.
                            </div>
                        </div>
                    </div>

                    {{-- Item 9 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading9">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse9"
                                aria-expanded="false" aria-controls="faqCollapse9">
                                <span class="faq-number">9</span>
                                Siapa saja yang bisa menggunakan layanan PELANGI?
                            </button>
                        </h2>
                        <div id="faqCollapse9" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading9" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                PELANGI terbuka untuk berbagai pihak, mulai dari <strong>nelayan lokal</strong>,
                                pengepul ikan, pedagang pasar, pemilik restoran, hingga masyarakat umum yang ingin
                                membeli hasil laut segar dengan harga yang transparan.
                            </div>
                        </div>
                    </div>

                    {{-- Item 10 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading10">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqCollapse10"
                                aria-expanded="false" aria-controls="faqCollapse10">
                                <span class="faq-number">10</span>
                                Apakah PELANGI sudah tersedia dalam versi aplikasi mobile?
                            </button>
                        </h2>
                        <div id="faqCollapse10" class="accordion-collapse collapse"
                            aria-labelledby="faqHeading10" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Saat ini PELANGI tersedia dalam <strong>versi website</strong> yang responsif dan
                                dapat diakses dengan nyaman melalui browser mobile. Versi aplikasi mobile sedang
                                dalam tahap pengembangan.
                            </div>
                        </div>
                    </div>

                </div>{{-- end accordion --}}

                {{-- CTA Banner --}}
                <div class="faq-cta" data-aos="fade-up" data-aos-delay="200">
                    <h3>Masih punya pertanyaan lain?</h3>
                    <p>Tim kami siap membantu Anda. Hubungi kami atau mulai daftar sekarang.</p>
                    <a href="{{ route('contact') }}" class="btn-outline-cta">
                        <i class="bi bi-envelope me-1"></i> Hubungi Kami
                    </a>
                    <a href="{{ route('register') }}" class="btn-cta">
                        <i class="bi bi-person-plus me-1"></i> Daftar Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection