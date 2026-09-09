<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Peluang')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700&family=DM+Mono:wght=400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navigasi.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.jpg') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/logo.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ─── Design Tokens ─────────────────────────────── */
        :root {
            --navy:       #0f1f3d;
            --navy-mid:   #162847;
            --navy-light: #1e3560;
            --gold:       #f0a500;
            --gold-dim:   #c4870a;
            --teal:       #0e9f82;
            --teal-dim:   #0b7d67;
            --white:      #ffffff;
            --gray-50:    #f8fafc;
            --gray-100:   #f1f5f9;
            --gray-400:   #94a3b8;
            --gray-600:   #475569;
            --text-main:  #1e293b;
            --radius-sm:  6px;
            --radius-md:  10px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-100);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Navbar ────────────────────────────────────── */
        .navbar {
            background: var(--navy);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,.35);
        }

        .navbar::after {
            content: '';
            display: block;
            height: 2px;
            background: var(--role-accent, var(--teal));
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 83px;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-brand-icon {
            width: 36px; height: 36px;
            background: var(--gold);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }
        .nav-brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -.3px;
        }
        .nav-brand-name span { color: var(--gold); }

        .nav-role-badge {
            font-size: .65rem;
            font-weight: 700;
            font-family: 'DM Mono', monospace;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .2rem .55rem;
            border-radius: 99px;
            border: 1px solid;
            flex-shrink: 0;
        }
        .role-tpi   { background: rgba(14,159,130,.15); color: #34d399; border-color: rgba(14,159,130,.35); }
        .role-dinas { background: rgba(99,102,241,.15); color: #a5b4fc; border-color: rgba(99,102,241,.35); }
        .role-admin { background: rgba(240,165,0,.15);  color: var(--gold); border-color: rgba(240,165,0,.35); }
        .role-pembeli { background: rgba(251,146,60,.15); color: #fb923c; border-color: rgba(251,146,60,.35); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .25rem;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .85rem;
            border-radius: var(--radius-sm);
            font-size: .875rem;
            font-weight: 500;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            transition: background .15s, color .15s;
            position: relative;
            white-space: nowrap;
        }
        .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: var(--white);
        }
        .nav-link.active {
            color: var(--gold);
            background: rgba(240,165,0,.1);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: .85rem; right: .85rem;
            height: 2px;
            background: var(--gold);
            border-radius: 2px 2px 0 0;
        }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-left: auto;
            flex-shrink: 0;
        }

        .nav-user {
            position: relative;
        }
        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: .55rem;
            padding: .4rem .7rem .4rem .45rem;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            color: var(--white);
            font-size: .85rem;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s;
        }
        .nav-user-btn:hover { background: rgba(255,255,255,.12); }
        .nav-user-avatar {
            width: 28px; height: 28px;
            border-radius: var(--radius-sm);
            background: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: .78rem;
            font-weight: 700;
            color: var(--navy);
            flex-shrink: 0;
        }
        .nav-user-info { line-height: 1.2; }
        .nav-user-name { font-size: .82rem; font-weight: 600; }
        .nav-user-role { font-size: .7rem; color: var(--gold); font-weight: 500; }
        .nav-user-chevron { width: 14px; height: 14px; color: rgba(255,255,255,.45); }

        .nav-dropdown {
            display: none;
            position: absolute;
            right: 0; top: calc(100% + 10px);
            min-width: 210px;
            background: var(--navy-mid);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--radius-md);
            box-shadow: 0 8px 32px rgba(0,0,0,.4);
            padding: .4rem;
            z-index: 200;
        }
        .nav-user:hover .nav-dropdown,
        .nav-user:focus-within .nav-dropdown { display: block; }

        .dropdown-header {
            padding: .55rem .75rem .4rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            margin-bottom: .3rem;
        }
        .dropdown-header p:first-child {
            font-size: .8rem;
            font-weight: 600;
            color: var(--white);
        }
        .dropdown-header p:last-child {
            font-size: .72rem;
            color: var(--gray-400);
            margin-top: 1px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .5rem .75rem;
            border-radius: var(--radius-sm);
            font-size: .82rem;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            transition: background .12s, color .12s;
        }
        .dropdown-item:hover { background: rgba(255,255,255,.07); color: var(--white); }
        .dropdown-item svg { width: 15px; height: 15px; flex-shrink: 0; }
        .dropdown-item.danger { color: #f87171; }
        .dropdown-item.danger:hover { background: rgba(239,68,68,.12); color: #fca5a5; }

        .dropdown-divider {
            height: 1px;
            background: rgba(255,255,255,.07);
            margin: .3rem .4rem;
        }

        /* ─── Page content area ──────────────────────────── */
        .page-content {
            flex: 1;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-header {
            margin-bottom: 1.75rem;
        }
        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: -.4px;
        }
        .page-header p {
            font-size: .9rem;
            color: var(--gray-600);
            margin-top: .3rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            color: var(--gray-400);
            margin-bottom: .6rem;
        }
        .breadcrumb a { color: var(--gray-400); text-decoration: none; }
        .breadcrumb a:hover { color: var(--navy); }
        .breadcrumb svg { width: 12px; height: 12px; }

        /* ─── Flash messages ─────────────────────────────── */
        .flash {
            padding: .8rem 1rem;
            border-radius: var(--radius-md);
            font-size: .87rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .flash-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .flash-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .flash svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ─── Footer ─────────────────────────────────────── */
        .footer {
            background: var(--navy);
            color: rgba(255,255,255,.6);
            margin-top: auto;
        }

        .footer-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 2rem;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 2.5rem;
        }

        .footer-brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: .6rem;
        }
        .footer-brand-name span { color: var(--gold); }

        .footer-tagline {
            font-size: .82rem;
            line-height: 1.65;
            max-width: 280px;
        }

        .footer-socials {
            display: flex;
            gap: .5rem;
            margin-top: 1.2rem;
        }
        .footer-social-btn {
            width: 34px; height: 34px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .footer-social-btn:hover { background: var(--gold); color: var(--navy); border-color: var(--gold); }
        .footer-social-btn svg { width: 15px; height: 15px; }

        .footer-col-title {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .55rem;
        }
        .footer-links a {
            font-size: .83rem;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            transition: color .15s;
        }
        .footer-links a:hover { color: var(--white); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .footer-bottom-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
        }
        .footer-bottom p {
            font-size: .78rem;
            color: rgba(255,255,255,.35);
        }
        .footer-bottom strong { color: rgba(255,255,255,.55); }
        .footer-bottom a {
            font-size: .78rem;
            color: rgba(255,255,255,.35);
            text-decoration: none;
        }
        .footer-bottom a:hover { color: rgba(255,255,255,.6); }
        .footer-bottom-links { display: flex; gap: 1.2rem; }

        /* ─── Responsive ─────────────────────────────────── */
        @media (max-width: 768px) {
            .nav-user-info, .nav-role-badge { display: none; }
            .nav-links .nav-link span { display: none; }
            .nav-link { padding: .45rem .6rem; }

            .footer-main {
                grid-template-columns: 1fr;
                gap: 1.75rem;
                padding: 2rem 1.25rem 1.5rem;
            }

            .page-content { padding: 1.25rem 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══════════════ NAVBAR ══════════════ --}}
<nav class="navbar">
    <div class="navbar-inner">

        {{-- Brand --}}
        <a href="{{ route('landingpage') }}" class="nav-brand">
            <div class="nav-brand-icon">🐟</div>
            <span class="nav-brand-name">Peluang<span>.</span></span>
        </a>

        {{-- Role Badge --}}
        @if(auth()->user()->role === 'tpi')
            <span class="nav-role-badge role-tpi">TPI</span>
        @elseif(auth()->user()->role === 'dinas')
            <span class="nav-role-badge role-dinas">Dinas</span>
        @elseif(auth()->user()->role === 'admin')
            <span class="nav-role-badge role-admin">Admin</span>
        @elseif(auth()->user()->role === 'pembeli')
            <span class="nav-role-badge role-pembeli">Pembeli</span>
        @endif

        {{-- Nav Links --}}
        <div class="nav-links">

            {{-- Dashboard — semua role --}}
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- ── TPI only ──────────────────────────────── --}}
            @if(auth()->user()->role === 'tpi')

                <a href="{{ route('jadwal.index') }}"
                   class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Jadwal</span>
                </a>

                <a href="{{ route('produk.index') }}"
                   class="nav-link {{ request()->routeIs('produk.*') || request()->routeIs('lelang.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <span>Produk</span>
                </a>

                <a href="{{ route('laporan.lelang') }}"
                   class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Laporan</span>
                </a>

            {{-- ── Dinas only ────────────────────────────── --}}
            @elseif(auth()->user()->role === 'dinas')

                <a href="{{ route('tpi.index') }}"
                   class="nav-link {{ request()->routeIs('tpi.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>TPI Saya</span>
                </a>

                <a href="{{ route('laporan.lelang') }}"
                   class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Laporan</span>
                </a>

            {{-- ── Admin only ────────────────────────────── --}}
            @elseif(auth()->user()->role === 'admin')

                <a href="{{ route('dinas.index') }}"
                   class="nav-link {{ request()->routeIs('dinas.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                    <span>Dinas</span>
                </a>

                <a href="{{ route('tpi.index') }}"
                   class="nav-link {{ request()->routeIs('tpi.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>TPI</span>
                </a>

                <a href="{{ route('pembeli.index') }}"
                   class="nav-link {{ request()->routeIs('pembeli.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pembeli</span>
                </a>

                <a href="{{ route('laporan.lelang') }}"
                   class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Laporan</span>
            </a>
            
            {{-- ── Pembeli only ──────────────────────────── --}}
            @elseif(auth()->user()->role === 'pembeli')
                <a href="{{ route('jadwal.index') }}"
                class="nav-link {{ request()->routeIs('pembeli.jadwal*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Jadwal</span>
                </a>

                <a href="{{ route('lelang.index') }}"
                class="nav-link {{ request()->routeIs('pembeli.lelang*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Lelang</span>
                </a>

            @endif

        </div>

        {{-- Right side --}}
        <div class="nav-right">

            {{-- User dropdown --}}
            <div class="nav-user" tabindex="0">
                <div class="nav-user-btn">
                    <div class="nav-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="nav-user-info">
                        <div class="nav-user-name">{{ auth()->user()->name }}</div>
                        <div class="nav-user-role">
                            @if(auth()->user()->role === 'tpi')   Pengelola TPI
                            @elseif(auth()->user()->role === 'dinas') Dinas Perikanan
                            @elseif(auth()->user()->role === 'admin') Administrator
                            @elseif(auth()->user()->role === 'pembeli') Pembeli
                            @endif
                        </div>
                    </div>
                    <svg class="nav-user-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div class="nav-dropdown">
                    <div class="dropdown-header">
                        <p>{{ auth()->user()->name }}</p>
                        <p>{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profil Saya
                    </a>

                    {{-- Shortcut laporan di dropdown --}}
                    @if(in_array(auth()->user()->role, ['tpi', 'dinas', 'admin']))
                        <a href="{{ route('laporan.export') }}" class="dropdown-item">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Ekspor Laporan
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="dropdown-item danger"
                                style="width:100%;background:none;border:none;text-align:left;cursor:pointer;font-family:inherit;font-size:.82rem;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</nav>

{{-- ══════════════ PAGE CONTENT ══════════════ --}}
<main class="page-content">

    {{-- Breadcrumb (opsional) --}}
    @hasSection('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Home</a>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        @yield('breadcrumb')
    </div>
    @endif

    {{-- Page title --}}
    @hasSection('page-title')
    <div class="page-header">
        <h1>@yield('page-title')</h1>
        @hasSection('page-subtitle')
        <p>@yield('page-subtitle')</p>
        @endif
    </div>
    @endif

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="flash flash-success">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash flash-error">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    @yield('content')
</main>

{{-- ══════════════ FOOTER ══════════════ --}}
<footer class="footer">
    <div class="footer-main">

        {{-- Brand col --}}
        <div>
            <div class="footer-brand-name">Peluang<span>.</span></div>
            <p class="footer-tagline">
                Platform pelelangan ikan digital yang menghubungkan nelayan dan pembeli secara cepat, transparan, dan terpercaya — demi mendukung ekonomi perikanan Banyuwangi.
            </p>
            <div class="footer-socials">
                <a href="#" class="footer-social-btn" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                    </svg>
                </a>
                <a href="#" class="footer-social-btn" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r=".5" fill="currentColor"/>
                    </svg>
                </a>
                <a href="#" class="footer-social-btn" aria-label="WhatsApp">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Menu col — disesuaikan per role --}}
        <div>
            <p class="footer-col-title">Menu</p>
            <ul class="footer-links">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

                @if(auth()->user()->role === 'tpi')
                    <li><a href="{{ route('jadwal.index') }}">Jadwal Lelang</a></li>
                    <li><a href="{{ route('produk.index') }}">Kelola Produk</a></li>
                    <li><a href="{{ route('laporan.lelang') }}">Laporan</a></li>

                @elseif(auth()->user()->role === 'dinas')
                    <li><a href="{{ route('tpi.index') }}">TPI Saya</a></li>
                    <li><a href="{{ route('laporan.lelang') }}">Laporan</a></li>

                @elseif(auth()->user()->role === 'admin')
                    <li><a href="{{ route('dinas.index') }}">Manajemen Dinas</a></li>
                    <li><a href="{{ route('tpi.index') }}">Manajemen TPI</a></li>
                    <li><a href="{{ route('pembeli.index') }}">Manajemen Pembeli</a></li>
                    <li><a href="{{ route('laporan.lelang') }}">Laporan</a></li>
                @elseif(auth()->user()->role === 'pembeli')
                    <li><a href="{{ route('jadwal.index') }}">Jadwal Lelang</a></li>
                    <li><a href="{{ route('lelang.index') }}">Ikut Lelang</a></li>
                @endif

                <li><a href="{{ route('profile.edit') }}">Profil Saya</a></li>
            </ul>
        </div>

        {{-- Info col --}}
        <div>
            <p class="footer-col-title">Informasi</p>
            <ul class="footer-links">
                <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
                <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>
            </ul>

            <p class="footer-col-title" style="margin-top:1.5rem">Kontak</p>
            <ul class="footer-links">
                <li>📍 Pelabuhan Perikanan, Banyuwangi</li>
                <li>✉️ info@peluang-banyuwangi.id</li>
                <li>📞 +62 812-3456-7890</li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>© {{ date('Y') }} <strong>Peluang</strong>. Pusat Pelelangan Ikan Terpadu Cemerlang. Semua hak dilindungi.</p>
            <div class="footer-bottom-links">
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>