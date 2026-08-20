@extends('layouts.landing')

@section('title', 'Login - Pelelangan Ikan Terpadu Cemerlang')
@section('description', 'Masuk ke akun Peluang - Pelelangan Ikan Terpadu Cemerlang')

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

    .auth-card .auth-form {
        padding: 50px 40px;
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
        margin-bottom: 28px;
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
        padding: .7rem 1rem;
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
        margin-bottom: 20px;
    }

    .auth-form .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        font-size: .85rem;
    }

    .auth-form .remember-row label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        color: var(--navy-text-muted);
        margin-bottom: 0;
        cursor: pointer;
    }

    .auth-form .remember-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--navy-700);
    }

    .auth-form .remember-row a {
        color: var(--navy-700);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-form .remember-row a:hover {
        color: var(--navy-accent);
    }

    .auth-form .btn-login {
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
    }

    .auth-form .btn-login:hover {
        background-color: var(--navy-accent);
        color: var(--navy-900);
        transform: translateY(-2px);
    }

    .auth-form .btn-login:disabled {
        opacity: .7;
        cursor: not-allowed;
        transform: none;
    }

    .auth-form .register-link {
        text-align: center;
        margin-top: 24px;
        font-size: .9rem;
        color: var(--navy-text-muted);
    }

    .auth-form .register-link a {
        color: var(--navy-700);
        font-weight: 700;
        text-decoration: none;
    }

    .auth-form .register-link a:hover {
        color: var(--navy-accent);
    }

    #login-error {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .85rem;
        margin-bottom: 16px;
    }

    .auth-status {
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .85rem;
        margin-bottom: 20px;
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

        .auth-card .auth-form {
            padding: 35px 30px;
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
                        
                        <h2>Selamat Datang Kembali di Peluang</h2>
                        <p>
                            Masuk untuk mengakses lelang ikan terbaru, memantau penawaran,
                            dan bertransaksi langsung dengan nelayan terpercaya di Banyuwangi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="auth-form">
                        <h1>Login</h1>
                        <span class="subtitle">Masukkan email dan kata sandi Anda untuk masuk</span>

                        @if (session('status'))
                            <div class="auth-status">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="login-form">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    required autofocus autocomplete="username">
                                @error('email')
                                    <span class="input-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <span class="input-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="remember-row">
                                <label for="remember_me">
                                    <input id="remember_me" type="checkbox" name="remember">
                                    Ingat saya
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Lupa sandi?</a>
                                @endif
                            </div>

                            <p id="login-error" class="hidden" style="display:none;"></p>

                            <button type="submit" class="btn-login">Masuk</button>

                            <div class="register-link">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konflik Sesi -->
<div id="conflict-modal" style="
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
    padding: 1rem;
">
    <div style="
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    ">
        <!-- Header -->
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <div style="
                width: 36px; height: 36px;
                border-radius: 50%;
                background: #fef3c7;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            ">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #111827;">
                Sesi aktif terdeteksi
            </h3>
        </div>

        <!-- Body -->
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 1rem; line-height: 1.6;">
            Akun ini sedang aktif di perangkat atau browser lain.
            Jika Anda melanjutkan, perangkat lain akan dikeluarkan secara otomatis.
        </p>

        <!-- Info box -->
        <div style="
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        ">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" style="flex-shrink:0">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <line x1="8" y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
            <span style="font-size: 13px; color: #6b7280;">
                Sesi di perangkat lain akan langsung diakhiri
            </span>
        </div>

        <!-- Tombol -->
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button
                type="button"
                id="btn-cancel-conflict"
                style="
                    padding: 8px 16px;
                    font-size: 14px;
                    border-radius: 8px;
                    border: 1px solid #d1d5db;
                    background: white;
                    color: #374151;
                    cursor: pointer;
                    font-weight: 500;
                "
            >
                Batal
            </button>
            <button
                type="button"
                id="btn-continue-login"
                style="
                    padding: 8px 18px;
                    font-size: 14px;
                    border-radius: 8px;
                    border: none;
                    background: #16335e;
                    color: white;
                    cursor: pointer;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                "
            >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Lanjutkan login
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    // ── Fingerprint ───────────────────────────────────────────────
    function generateFingerprint() {
        const canvas = document.createElement('canvas');
        const ctx    = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font         = '14px Arial';
        ctx.fillText('fingerprint', 2, 2);

        const components = [
            navigator.userAgent,
            navigator.language,
            screen.colorDepth,
            screen.width + 'x' + screen.height,
            new Date().getTimezoneOffset(),
            !!window.sessionStorage,
            !!window.localStorage,
            canvas.toDataURL(),
        ];

        return hashString(components.join('|||'));
    }

    function hashString(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            const c = str.charCodeAt(i);
            hash    = (hash << 5) - hash + c;
            hash    = hash & hash;
        }
        return Math.abs(hash).toString(36);
    }

    function getFingerprint() {
        const match = document.cookie.match(/device_fp=([^;]+)/);
        if (match) return match[1];

        const fp      = generateFingerprint();
        const expires = new Date();
        expires.setFullYear(expires.getFullYear() + 1);
        document.cookie = `device_fp=${fp}; expires=${expires.toUTCString()}; path=/; SameSite=Strict`;
        return fp;
    }

    // ── Elemen DOM ────────────────────────────────────────────────
    const loginForm  = document.getElementById('login-form');
    const errorBox   = document.getElementById('login-error');
    const modal      = document.getElementById('conflict-modal');
    const btnCancel  = document.getElementById('btn-cancel-conflict');
    const btnContinue = document.getElementById('btn-continue-login');
    const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    function showError(msg) {
        errorBox.textContent = msg;
        errorBox.style.display = 'block';
    }

    function hideError() {
        errorBox.style.display = 'none';
    }

    function showModal() {
        modal.style.display = 'flex';
    }

    function hideModal() {
        modal.style.display = 'none';
    }

    // ── Fetch cek fingerprint ─────────────────────────────────────
    async function checkFingerprint(email, pass, action = '') {
        hideError();

        btnContinue.disabled = true;
        btnContinue.textContent = 'Memproses...';

        const fp = getFingerprint();

        try {
            const res = await fetch("{{ route('cek.fingerprint') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    username:  email,
                    pass:      pass,
                    action:    action,
                    device_fp: fp,
                }),
            });

            const data = await res.json();
            console.log('[Login] Response:', data);

            if (data.status === 'invalid') {
                showError(data.message);
                resetContinueButton();
                return;
            }

            if (data.status === 'conflict') {
                showModal();
                resetContinueButton();
                return;
            }

            if (data.status === 'ok' && data.valid) {
                hideModal();
                loginForm.dataset.bypass = 'true';
                loginForm.submit();
            }

        } catch (err) {
            console.error('[Login] Error:', err);
            showError('Terjadi kesalahan koneksi. Coba lagi.');
            resetContinueButton();
        }
    }

    function resetContinueButton() {
        btnContinue.disabled = false;
        btnContinue.innerHTML = `
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Lanjutkan login
        `;
    }

    // ── Event listeners ───────────────────────────────────────────
    loginForm.addEventListener('submit', function (e) {
        if (this.dataset.bypass === 'true') return;

        e.preventDefault();

        const email = document.getElementById('email').value;
        const pass  = document.getElementById('password').value;

        checkFingerprint(email, pass);
    });

    btnCancel.addEventListener('click', function () {
        hideModal();
    });

    btnContinue.addEventListener('click', function () {
        const email = document.getElementById('email').value;
        const pass  = document.getElementById('password').value;
        checkFingerprint(email, pass, 'keep');
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) hideModal();
    });

})();
</script>
@endpush