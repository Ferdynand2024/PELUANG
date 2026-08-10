@extends('layouts.navigasi')

@section('title', 'Dashboard — Pelangi')
@section('page-title', 'Dashboard')
@section('page-subtitle')Selamat datang kembali, {{ auth()->user()->name }}!@endsection

@push('styles')
<style>
    /* ── Welcome hero ───────────────────────────── */
    .welcome-hero {
        background: linear-gradient(135deg, #0f1f3d 0%, #1e3560 60%, #162847 100%);
        border-radius: 14px;
        padding: 2rem 2.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-hero::before {
        content: attr(data-icon);
        position: absolute;
        right: 2rem; top: 50%;
        transform: translateY(-50%);
        font-size: 7rem;
        opacity: .07;
        pointer-events: none;
        line-height: 1;
    }
    .welcome-text h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -.3px;
        margin-bottom: .35rem;
    }
    .welcome-text p {
        font-size: .9rem;
        color: rgba(255,255,255,.6);
        max-width: 420px;
        line-height: 1.6;
    }
    .welcome-actions {
        display: flex;
        gap: .75rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .btn-hero-primary {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 1.5rem;
        background: #f0a500;
        color: #0f1f3d;
        border-radius: 9px;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        transition: background .15s, transform .1s;
        white-space: nowrap;
    }
    .btn-hero-primary:hover { background: #c4870a; color: #fff; }
    .btn-hero-primary:active { transform: scale(.97); }
    .btn-hero-primary svg { width: 17px; height: 17px; }
    .btn-hero-secondary {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 1.25rem;
        background: rgba(255,255,255,.1);
        color: rgba(255,255,255,.85);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 9px;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .15s;
        white-space: nowrap;
    }
    .btn-hero-secondary:hover { background: rgba(255,255,255,.18); color: #fff; }
    .btn-hero-secondary svg { width: 16px; height: 16px; }

    /* ── Info card ──────────────────────────────── */
    .info-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        margin-bottom: 1.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .info-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 1.2rem;
    }
    .info-icon.blue   { background: #dbeafe; }
    .info-icon.gold   { background: #fef3c7; }
    .info-icon.green  { background: #dcfce7; }
    .info-icon.purple { background: #f3e8ff; }
    .info-card-text h4 { font-size: .95rem; font-weight: 700; color: #0f1f3d; margin-bottom: .25rem; }
    .info-card-text p  { font-size: .84rem; color: #64748b; line-height: 1.65; }

    /* ── Section title ──────────────────────────── */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Fish / Feature cards ───────────────────── */
    .fish-showcase,
    .feature-showcase {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .fish-item,
    .feature-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 1.1rem 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        transition: transform .18s, box-shadow .18s;
    }
    .fish-item:hover,
    .feature-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,.09);
    }
    .fish-item-icon,
    .feature-item-icon { font-size: 1.75rem; margin-bottom: .6rem; }
    .fish-item h4,
    .feature-item h4 { font-size: .9rem; font-weight: 700; color: #0f1f3d; margin-bottom: .3rem; }
    .fish-item p,
    .feature-item p  { font-size: .8rem; color: #64748b; line-height: 1.55; }

    /* ── Tips card ──────────────────────────────── */
    .tips-card {
        background: linear-gradient(135deg, #fefce8, #fef9c3);
        border: 1px solid #fde68a;
        border-left: 4px solid #f0a500;
        border-radius: 11px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.75rem;
    }
    .tips-card h3 { font-size: .95rem; font-weight: 700; color: #78350f; margin-bottom: .75rem; }
    .tips-list { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
    .tips-list li {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        font-size: .84rem;
        color: #44403c;
        line-height: 1.5;
    }
    .tips-list li::before {
        content: '✓';
        width: 18px; height: 18px;
        background: #f0a500;
        color: #fff;
        font-size: .65rem;
        font-weight: 700;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ── CTA Banner ─────────────────────────────── */
    .cta-banner {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .cta-banner-text h3 { font-size: 1rem; font-weight: 700; color: #0f1f3d; margin-bottom: .25rem; }
    .cta-banner-text p  { font-size: .84rem; color: #64748b; }
    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .7rem 1.5rem;
        background: #0f1f3d;
        color: #fff;
        border-radius: 9px;
        font-size: .875rem;
        font-weight: 700;
        text-decoration: none;
        flex-shrink: 0;
        transition: background .15s;
    }
    .btn-cta:hover { background: #162847; color: #f0a500; }
    .btn-cta svg { width: 16px; height: 16px; }

    /* ── Stats row (TPI / Admin / Dinas) ────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        text-align: center;
    }
    .stat-card .stat-icon { font-size: 1.8rem; margin-bottom: .4rem; }
    .stat-card .stat-value { font-size: 1.5rem; font-weight: 800; color: #0f1f3d; }
    .stat-card .stat-label { font-size: .78rem; color: #64748b; margin-top: .15rem; }

    /* ── Responsive ─────────────────────────────── */
    @media (max-width: 900px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .feature-showcase { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .welcome-hero { flex-direction: column; align-items: flex-start; }
        .welcome-actions { flex-wrap: wrap; }
        .fish-showcase { grid-template-columns: 1fr 1fr; }
        .cta-banner { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 480px) {
        .fish-showcase,
        .feature-showcase { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

@php
    $userRole = strtolower(auth()->user()->role ?? 'pembeli');
@endphp

{{-- ════════════════════════════════════════════════
     ROLE: PEMBELI
     ════════════════════════════════════════════════ --}}
@if($userRole === 'pembeli')

    {{-- Welcome Hero --}}
    <div class="welcome-hero" data-icon="🐟">
        <div class="welcome-text">
            <h2>Selamat datang, {{ auth()->user()->name }}! 👋</h2>
            <p>Temukan ikan segar terbaik langsung dari nelayan Banyuwangi.
               Ikuti lelang sekarang dan dapatkan harga terbaik.</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('lelang.index') }}" class="btn-hero-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Ikuti Lelang Sekarang
            </a>
            <a href="{{ route('jadwal.index') }}" class="btn-hero-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Jadwal
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-icon blue">ℹ️</div>
        <div class="info-card-text">
            <h4>Sistem Pelelangan Ikan Pelangi</h4>
            <p>Sebagai pembeli, Anda dapat mengikuti lelang ikan segar langsung dari nelayan terpercaya,
               melihat jadwal lelang, dan melakukan penawaran. Periksa jadwal secara berkala dan siapkan
               saldo yang cukup untuk mendapatkan ikan berkualitas terbaik dengan harga kompetitif.</p>
        </div>
    </div>

    {{-- Fish Showcase --}}
    <p class="section-title">🎣 Jenis Ikan Populer di Lelang</p>
    <div class="fish-showcase">
        <div class="fish-item">
            <div class="fish-item-icon">🐟</div>
            <h4>Tuna</h4>
            <p>Ikan laut bernilai tinggi, cocok untuk ekspor dan konsumsi lokal premium.</p>
        </div>
        <div class="fish-item">
            <div class="fish-item-icon">🐠</div>
            <h4>Cakalang</h4>
            <p>Populer di pasar lokal, sering digunakan dalam makanan kaleng dan masakan khas.</p>
        </div>
        <div class="fish-item">
            <div class="fish-item-icon">🐡</div>
            <h4>Kembung</h4>
            <p>Terjangkau dan banyak dicari, ideal untuk konsumsi harian masyarakat.</p>
        </div>
    </div>

    {{-- Tips --}}
    <div class="tips-card">
        <h3>💡 Tips Menang Lelang</h3>
        <ul class="tips-list">
            <li>Selalu cek jadwal lelang terbaru setiap hari agar tidak ketinggalan sesi.</li>
            <li>Perhatikan kualitas, berat, dan jenis ikan sebelum melakukan penawaran.</li>
            <li>Siapkan saldo mencukupi sebelum bidding — penawaran tidak bisa dibatalkan.</li>
        </ul>
    </div>

    {{-- Bottom CTA --}}
    <div class="cta-banner">
        <div class="cta-banner-text">
            <h3>Ada lelang yang sedang berlangsung sekarang!</h3>
            <p>Jangan sampai ketinggalan — penawaran terbaik selalu datang lebih awal.</p>
        </div>
        <a href="{{ route('lelang.index') }}" class="btn-cta">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
            Lihat Semua Lelang
        </a>
    </div>


{{-- ════════════════════════════════════════════════
     ROLE: TPI
     ════════════════════════════════════════════════ --}}
@elseif($userRole === 'tpi')

    {{-- Welcome Hero --}}
    <div class="welcome-hero" data-icon="⚓">
        <div class="welcome-text">
            <h2>Halo, {{ auth()->user()->name }}! ⚓</h2>
            <p>Kelola sesi lelang, verifikasi data tangkapan, dan pantau aktivitas
               pelelangan hari ini dari panel TPI.</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('produk.index') }}" class="btn-hero-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Kelola Lelang
            </a>
            <a href="{{ route('jadwal.index') }}" class="btn-hero-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Atur Jadwal
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-icon green">🏭</div>
        <div class="info-card-text">
            <h4>Panel Pengelola TPI</h4>
            <p>Anda bertugas membuka sesi lelang, menginput data tangkapan nelayan,
               menetapkan harga dasar, dan memverifikasi transaksi yang masuk.
               Pastikan semua data akurat sebelum sesi lelang dibuka.</p>
        </div>
    </div>

    {{-- Stats --}}
    <p class="section-title">📊 Ringkasan Hari Ini</p>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">🎣</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Sesi Lelang Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🐟</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Lot Tersedia</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Peserta Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Transaksi Selesai</div>
        </div>
    </div>

    {{-- Feature Cards --}}
    <p class="section-title">⚙️ Menu Utama TPI</p>
    <div class="feature-showcase">
        <div class="feature-item">
            <div class="feature-item-icon">📋</div>
            <h4>Input Data Tangkapan</h4>
            <p>Catat jenis, berat, dan kualitas ikan hasil tangkapan nelayan sebelum lelang dibuka.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">🔔</div>
            <h4>Buka / Tutup Sesi</h4>
            <p>Kendalikan sesi lelang secara real-time dan umumkan pemenang setiap lot.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">🧾</div>
            <h4>Verifikasi Transaksi</h4>
            <p>Konfirmasi pembayaran dan cetak bukti transaksi untuk pembeli dan nelayan.</p>
        </div>
    </div>

    {{-- Tips --}}
    <div class="tips-card">
        <h3>📌 Panduan Operasional TPI</h3>
        <ul class="tips-list">
            <li>Pastikan data nelayan dan tangkapan sudah diverifikasi sebelum sesi dimulai.</li>
            <li>Tetapkan harga dasar sesuai referensi harga pasar harian.</li>
            <li>Catat semua transaksi dan simpan bukti untuk laporan harian ke Dinas.</li>
        </ul>
    </div>


{{-- ════════════════════════════════════════════════
     ROLE: ADMIN
     ════════════════════════════════════════════════ --}}
@elseif($userRole === 'admin')

    {{-- Welcome Hero --}}
    <div class="welcome-hero" data-icon="🛡️">
        <div class="welcome-text">
            <h2>Selamat datang, Admin {{ auth()->user()->name }}! 🛡️</h2>
            <p>Kelola seluruh pengguna, data sistem, dan konfigurasi platform
               Pelelangan Ikan Pelangi dari panel administrasi terpusat.</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('dinas.index') }}" class="btn-hero-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Pengguna
            </a>
            <a href="{{ route('laporan.lelang') }}" class="btn-hero-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat Laporan
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-icon purple">🛡️</div>
        <div class="info-card-text">
            <h4>Panel Administrasi Sistem</h4>
            <p>Sebagai Admin, Anda memiliki akses penuh untuk mengelola akun pengguna,
               memantau aktivitas seluruh TPI, mengatur konfigurasi sistem, serta
               menghasilkan laporan komprehensif untuk kebutuhan audit.</p>
        </div>
    </div>

    {{-- Stats --}}
    <p class="section-title">📊 Statistik Sistem</p>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏭</div>
            <div class="stat-value">—</div>
            <div class="stat-label">TPI Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Laporan Masalah</div>
        </div>
    </div>

    {{-- Feature Cards --}}
    <p class="section-title">⚙️ Menu Administrasi</p>
    <div class="feature-showcase">
        <div class="feature-item">
            <div class="feature-item-icon">👤</div>
            <h4>Manajemen Pengguna</h4>
            <p>Tambah, edit, nonaktifkan akun pembeli, nelayan, TPI, dan Dinas.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">🏭</div>
            <h4>Manajemen TPI</h4>
            <p>Daftarkan dan kelola data Tempat Pelelangan Ikan yang terhubung ke sistem.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">📈</div>
            <h4>Laporan & Audit</h4>
            <p>Akses laporan transaksi, aktivitas sistem, dan log pengguna untuk audit.</p>
        </div>
    </div>

    {{-- Tips --}}
    <div class="tips-card">
        <h3>🔐 Catatan Keamanan Admin</h3>
        <ul class="tips-list">
            <li>Tinjau log aktivitas secara berkala untuk mendeteksi anomali sistem.</li>
            <li>Nonaktifkan akun yang tidak aktif atau mencurigakan segera.</li>
            <li>Lakukan backup data sistem minimal seminggu sekali.</li>
        </ul>
    </div>


{{-- ════════════════════════════════════════════════
     ROLE: DINAS
     ════════════════════════════════════════════════ --}}
@elseif($userRole === 'dinas')

    {{-- Welcome Hero --}}
    <div class="welcome-hero" data-icon="📊">
        <div class="welcome-text">
            <h2>Selamat datang, {{ auth()->user()->name }}! 📊</h2>
            <p>Pantau kinerja pelelangan, analisis data produksi perikanan, dan
               unduh laporan resmi dari seluruh TPI di Banyuwangi.</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('laporan.lelang') }}" class="btn-hero-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat Laporan
            </a>
            <a href="#" class="btn-hero-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Statistik Produksi
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-icon gold">🏛️</div>
        <div class="info-card-text">
            <h4>Portal Pemantauan Dinas Perikanan</h4>
            <p>Sebagai Dinas, Anda dapat memantau seluruh aktivitas pelelangan ikan,
               menganalisis tren produksi dan harga, serta mengunduh laporan resmi
               untuk keperluan perencanaan dan kebijakan daerah.</p>
        </div>
    </div>

    {{-- Stats --}}
    <p class="section-title">📊 Ringkasan Produksi</p>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">🏭</div>
            <div class="stat-value">—</div>
            <div class="stat-label">TPI Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚖️</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Total Produksi (kg)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Nilai Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🚢</div>
            <div class="stat-value">—</div>
            <div class="stat-label">Nelayan Aktif</div>
        </div>
    </div>

    {{-- Feature Cards --}}
    <p class="section-title">📋 Fitur Pemantauan</p>
    <div class="feature-showcase">
        <div class="feature-item">
            <div class="feature-item-icon">📉</div>
            <h4>Analisis Harga</h4>
            <p>Pantau tren harga ikan harian dan bandingkan antar TPI di seluruh wilayah.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">📦</div>
            <h4>Data Produksi</h4>
            <p>Lihat volume tangkapan per jenis ikan, per TPI, dan per periode waktu.</p>
        </div>
        <div class="feature-item">
            <div class="feature-item-icon">📄</div>
            <h4>Ekspor Laporan</h4>
            <p>Unduh laporan dalam format PDF atau Excel untuk dokumentasi resmi dinas.</p>
        </div>
    </div>

    {{-- Tips --}}
    <div class="tips-card">
        <h3>📌 Panduan Penggunaan Portal Dinas</h3>
        <ul class="tips-list">
            <li>Gunakan filter tanggal dan TPI untuk mendapatkan laporan yang spesifik.</li>
            <li>Unduh laporan bulanan sebelum akhir bulan untuk rekap data produksi.</li>
            <li>Hubungi Admin jika terdapat ketidaksesuaian data antar TPI.</li>
        </ul>
    </div>

    {{-- Bottom CTA --}}
    <div class="cta-banner">
        <div class="cta-banner-text">
            <h3>Laporan bulan ini siap diunduh!</h3>
            <p>Data produksi dan transaksi seluruh TPI telah terekap dan siap diekspor.</p>
        </div>
        <a href="#" class="btn-cta">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Unduh Laporan
        </a>
    </div>

@endif

@endsection