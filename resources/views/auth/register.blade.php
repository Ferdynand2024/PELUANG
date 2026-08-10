@extends('layouts.landing')

@section('title', 'Daftar - Pelelangan Ikan Banyuwangi')
@section('description', 'Daftar akun Pelangi - Pusat Pelelangan Ikan Banyuwangi')

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

    /* ===== Auth Section ===== */
    .auth-section {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        padding: 60px 0;
        background: #fff;
    }

    .auth-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 14px 40px rgba(7, 20, 43, .25);
        overflow: hidden;
        max-width: 880px;
        margin: 0 auto;
    }

    .auth-card .auth-side {
        background: linear-gradient(160deg, var(--navy-900) 0%, var(--navy-700) 100%);
        color: #fff;
        padding: 50px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .auth-card .auth-side i {
        font-size: 3rem;
        color: var(--navy-accent);
        margin-bottom: 20px;
    }

    .auth-card .auth-side h2 {
        color: #fff;
        font-weight: 800;
        font-size: 1.6rem;
        margin-bottom: 12px;
    }

    .auth-card .auth-side p {
        color: #c3cde0;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .auth-card .auth-side ul {
        list-style: none;
        padding: 0;
        margin: 20px 0 0 0;
    }

    .auth-card .auth-side ul li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .9rem;
        color: #c3cde0;
        margin-bottom: 12px;
    }

    .auth-card .auth-side ul li i {
        font-size: 1.1rem;
        color: var(--navy-accent);
        margin-bottom: 0;
    }

    .auth-card .auth-form {
        padding: 45px 40px;
    }

    .auth-card .auth-form h1 {
        color: var(--navy-900);
        font-weight: 800;
        font-size: 1.6rem;
        margin-bottom: 6px;
    }

    .auth-card .auth-form .subtitle {
        color: var(--navy-text-muted);
        font-size: .9rem;
        margin-bottom: 24px;
        display: block;
    }

    .auth-form label {
        font-weight: 600;
        font-size: .85rem;
        color: var(--navy-900);
        margin-bottom: 6px;
        display: block;
    }

    .auth-form input[type="email"],
    .auth-form input[type="password"],
    .auth-form input[type="text"] {
        width: 100%;
        border: 1px solid #cdd6e4;
        border-radius: 10px;
        padding: .65rem 1rem;
        font-size: .95rem;
        transition: border-color .2s ease, box-shadow .2s ease;
        background: var(--navy-soft);
    }

    .auth-form input:focus {
        outline: none;
        border-color: var(--navy-600);
        box-shadow: 0 0 0 3px rgba(36, 74, 133, .15);
        background: #fff;
    }

    .auth-form .form-group {
        margin-bottom: 16px;
    }

    .auth-form .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .auth-form .btn-register {
        width: 100%;
        background-color: var(--navy-700);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: .8rem 1.5rem;
        font-weight: 700;
        font-size: 1rem;
        transition: background-color .2s ease, transform .2s ease;
        cursor: pointer;
        margin-top: 8px;
    }

    .auth-form .btn-register:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        transform: translateY(-2px);
    }

    .auth-form .login-link {
        text-align: center;
        margin-top: 20px;
        font-size: .9rem;
        color: var(--navy-text-muted);
    }

    .auth-form .login-link a {
        color: var(--navy-700);
        font-weight: 700;
        text-decoration: none;
    }

    .auth-form .login-link a:hover {
        color: var(--navy-accent);
    }

    .input-error-msg {
        color: #dc2626;
        font-size: .8rem;
        margin-top: 4px;
        display: block;
    }

    @media (max-width: 767px) {
        .auth-card .auth-side {
            padding: 35px 30px;
            text-align: center;
            align-items: center;
        }

        .auth-card .auth-side ul {
            text-align: left;
        }

        .auth-card .auth-form {
            padding: 35px 30px;
        }

        .auth-form .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
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

<section class="auth-section">
    <div class="container">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="auth-side">
                        <i class="bi bi-anchor"></i>
                        <h2>Gabung Bersama Pelangi</h2>
                        <p>
                            Daftarkan diri Anda untuk mulai mengikuti lelang ikan segar
                            langsung dari nelayan Banyuwangi.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> Akses lelang real-time</li>
                            <li><i class="bi bi-check-circle"></i> Harga transparan & kompetitif</li>
                            <li><i class="bi bi-check-circle"></i> Dukung nelayan lokal</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="auth-form">
                        <h1>Daftar Akun</h1>
                        <span class="subtitle">Lengkapi data diri Anda untuk membuat akun baru</span>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                    required autofocus autocomplete="name">
                                @error('name')
                                    <span class="input-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        required autocomplete="username">
                                    @error('email')
                                        <span class="input-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                        onkeypress="return onlyNumberKey(event)">
                                    @error('phone')
                                        <span class="input-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}">
                                @error('alamat')
                                    <span class="input-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="input-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Ulangi Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="input-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn-register">Daftar</button>

                            <div class="login-link">
                                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
@endpush