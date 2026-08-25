<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
    <meta name="user-email" content="{{ auth()->user()->email }}">
    @endauth

    <title>{{ isset($title) ? $title . ' / ' . config('app.name', 'Pelelangan Ikan Terpadu Cemerlang') : config('app.name', 'Pelelangan Ikan Terpadu Cemerlang') }}</title>

    <!-- Favicon custom (logo asli Peluang) -->
    <link rel="icon" href="{{ asset('assets/img/logo.jpg') }}" type="image/png">

    <!-- PWA Manifest, theme-color, apple-touch-icon (auto dari package silviolleite/laravelpwa) -->
    @laravelPWA

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased @auth protected-page @endauth">

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @auth
    <!-- Form logout tersembunyi untuk auto-logout via JS -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
        @csrf
    </form>

    <!-- Toast notifikasi sebelum auto-logout -->
    <div id="logout-toast" style="
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        background: #ef4444;
        color: white;
        padding: 16px 20px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        max-width: 340px;
        line-height: 1.6;
        animation: slideIn 0.3s ease;
    ">
        <strong>⚠️ Sesi Diakhiri</strong><br>
        Akun Anda login di perangkat lain.<br>
        Anda akan dikeluarkan dalam 3 detik...
    </div>

    <style>
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
    </style>

    <!-- Load RealtimeMonitor class -->
    <script src="{{ asset('js/realtime.js') }}"></script>

    <script>
    (function () {
        // ── Helpers ───────────────────────────────────────────────────
        function getDeviceFp() {
            const match = document.cookie.match(/device_fp=([^;]+)/);
            return match ? match[1] : null;
        }

        const metaEmail    = document.querySelector('meta[name="user-email"]');
        const currentEmail = metaEmail ? metaEmail.content : null;
        const currentFp    = getDeviceFp();

        if (!currentEmail || !currentFp) {
            console.warn('[RealtimeMonitor] Data tidak lengkap, monitoring dilewati.');
            return;
        }

        // ── Auto logout ───────────────────────────────────────────────
        let logoutScheduled = false;

        function triggerAutoLogout() {
            if (logoutScheduled) return;
            logoutScheduled = true;

            console.warn('[RealtimeMonitor] Fingerprint berubah → auto logout...');

            const toast = document.getElementById('logout-toast');
            if (toast) toast.style.display = 'block';

            // Countdown 3 detik agar user sempat membaca notifikasi
            setTimeout(function () {
                document.getElementById('logout-form').submit();
            }, 3000);
        }

        // ── Inisialisasi RealtimeMonitor ──────────────────────────────
        const monitor = new RealtimeMonitor({
            baseUrl: window.location.origin + '/',
            user:    currentEmail,

            onConnected: function () {
                console.log('[RealtimeMonitor] Aktif untuk:', currentEmail, '| fp:', currentFp);
            },

            onDisconnected: function () {
                console.warn('[RealtimeMonitor] Koneksi terputus, reconnect...');
            },

            onError: function (err) {
                console.error('[RealtimeMonitor] Error:', err);
            },

            onUpdateAttendance: function (attendance) {
                console.log('[RealtimeMonitor] Update diterima:', attendance);

                // Hanya proses jika untuk user ini
                if (attendance.email !== currentEmail) return;

                // Jika fp di DB sudah beda dari fp cookie kita → ada login baru
                if (attendance.fingerprint_device !== currentFp) {
                    triggerAutoLogout();
                }
            },

            onNewAttendance: function (attendance) {
                console.log('[RealtimeMonitor] New attendance:', attendance);
            },
        });

        // ── Start monitoring ──────────────────────────────────────────
        function startMonitoring() {
            const isProtected = document.body.classList.contains('protected-page');
            const isVideo    = document.body.classList.contains('video-render');

            if (isProtected && !isVideo) {
                monitor.start();
            }
        }

        document.addEventListener('DOMContentLoaded', startMonitoring);
        window.addEventListener('beforeunload', function () { monitor.stop(); });

    })();
    </script>
    @endauth

</body>
</html>