@extends('layouts.landing')

@section('title', 'Contact - Pelelangan Ikan Terpadu Cemerlang')
@section('description', 'Hubungi Pusat Pelelangan Ikan Terpadu Cemerlang (PELUANG) - Terhubung dengan tim kami untuk pertanyaan dan dukungan.')

@push('styles')
<style>
    :root {
        --navy-900: #0f1f3d;;
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
        color: #fff;
        font-weight: 700;
    }

    #header .navmenu ul li a {
        color: #e6ecf7;
        font-weight: 500;
        transition: color .2s ease;
    }

    #header .navmenu ul li a:hover,
    #header .navmenu ul li a:focus,
    #header .navmenu ul li a.active {
        color: var(--navy-accent);
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

    /* ===== Contact Section ===== */
    .contact .info-item {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .08);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .contact .info-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(7, 20, 43, .12);
    }

    .contact .info-item i {
        font-size: 24px;
        color: var(--navy-accent);
        background-color: var(--navy-900);
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }

    .contact .info-item h4 {
        color: var(--navy-900);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 4px;
    }

    .contact .info-item p {
        color: #6b7785;
        margin-bottom: 0;
        font-size: .9rem;
    }

    .contact .php-email-form {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 6px 18px rgba(7, 20, 43, .08);
        height: 100%;
    }

    .contact .php-email-form .form-control {
        border: 1px solid #cdd6e4;
        border-radius: 10px;
        padding: .75rem 1.1rem;
        font-size: .95rem;
        box-shadow: none;
    }

    .contact .php-email-form .form-control:focus {
        border-color: var(--navy-600);
        box-shadow: 0 0 0 3px rgba(36, 74, 133, .15);
    }

    .contact .php-email-form button[type=submit] {
        background-color: var(--navy-700);
        border: none;
        border-radius: 50px;
        padding: .75rem 2.5rem;
        font-weight: 600;
        transition: background-color .2s ease, transform .2s ease;
    }

    .contact .php-email-form button[type=submit]:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        transform: translateY(-2px);
    }

    .contact #success-message {
        border-radius: 10px;
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

<div class="page-title light-background">
    <div class="container">
        <h1>Contact Us</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('landingpage') }}">Home</a></li>
                <li class="current">Contact</li>
            </ol>
        </nav>
    </div>
</div>

<section id="contact" class="contact section">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-5 d-flex flex-column">
                <div class="info-item d-flex align-items-center" data-aos="fade-up">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                        <h4>Lokasi:</h4>
                        <p>Dinas Perikanan Banyuwangi, Jawa Timur, Indonesia</p>
                    </div>
                </div>
                <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                        <h4>Email:</h4>
                        <p>info@peluang-bwi.id</p>
                    </div>
                </div>
                <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-phone flex-shrink-0"></i>
                    <div>
                        <h4>Telepon:</h4>
                        <p>+62 812-3456-7890</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                <form onsubmit="return showSuccessMessage()" class="php-email-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="subject" class="form-control" placeholder="Subjek" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" rows="5" class="form-control" placeholder="Pesan Anda" required></textarea>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </div>
                    <div id="success-message" class="alert alert-success text-center d-none">
                        Pesan berhasil dikirim. Terima kasih telah menghubungi kami!
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function showSuccessMessage() {
        const messageDiv = document.getElementById('success-message');
        messageDiv.classList.remove('d-none');
        messageDiv.scrollIntoView({
            behavior: 'smooth'
        });
        document.querySelector('.php-email-form').reset();
        return false;
    }
</script>
@endpush