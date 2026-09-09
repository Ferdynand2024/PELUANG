@extends('layouts.landing')

@section('title', 'Cari TPI Terdekat - Pelelangan Ikan Terpadu Cemerlang')

@push('styles')
<style>
    :root {
        --navy-900: #0f1f3d;
        --navy-800: #0f1f3d;
        --navy-700: #0f1f3d;
        --navy-accent: #f4a300;
        --navy-soft: #eef2f9;
    }

    body {
        background-color: var(--navy-soft);
    }

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
    }

    .page-title .breadcrumbs ol li.current {
        color: #f4a300;
    }

    .page-title .breadcrumbs ol li + li::before {
        content: '/';
        margin-right: 8px;
        color: #7a90b0;
    }

    .tpi-search-section {
        padding: 60px 0;
    }

    .tpi-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        background: #ffffff;
    }

    .tpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .distance-badge {
        background-color: rgba(15, 31, 61, 0.08);
        color: var(--navy-900);
        font-weight: 700;
        font-size: 0.9rem;
        padding: 6px 14px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .preset-btn {
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        color: #495057;
        font-size: 0.85rem;
        border-radius: 20px;
        padding: 5px 15px;
        transition: all 0.2s ease;
    }

    .preset-btn:hover {
        background-color: var(--navy-900);
        color: #ffffff;
        border-color: var(--navy-900);
    }

    /* FITUR BARU: badge status lelang aktif di card TPI */
    .lelang-badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .lelang-badge.is-active {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .lelang-badge.is-active .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #dc3545;
        animation: pulse-dot 1.5s infinite;
    }

    .lelang-badge.is-inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    @keyframes pulse-dot {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    /* FITUR BARU: styling item produk lelang di dalam modal */
    .produk-lelang-item {
        border: 1px solid #eef0f3;
        border-radius: 12px;
        padding: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .produk-lelang-item img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        background-color: #f1f3f5;
    }

    .produk-lelang-item .harga-current {
        color: var(--navy-900);
        font-weight: 800;
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

{{-- Page Title --}}
<div class="page-title light-background">
    <div class="container">
        <h1>Cari TPI Terdekat</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('landingpage') }}">Home</a></li>
                <li class="current">Cari TPI</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Section --}}
<section class="tpi-search-section">
    <div class="container">

        {{-- Hero / Control Box --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                    <div class="mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 64px; height: 64px;">
                            <i class="bi bi-geo-alt-fill fs-2"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-2">Temukan Tempat Pelelangan Ikan Terdekat</h3>
                    <p class="text-muted mb-4">
                        Gunakan lokasi otomatis browser atau masukkan koordinat lokasi Anda untuk menemukan TPI terdekat.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        <button id="btn-location" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" onclick="getLocation()">
                            <i class="bi bi-crosshair me-2"></i> Gunakan Lokasi Saya (GPS)
                        </button>
                        <button class="btn btn-outline-secondary btn-lg rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#manual-location-collapse" aria-expanded="false">
                            <i class="bi bi-pencil-square me-2"></i> Input Koordinat Manual
                        </button>
                    </div>

                    {{-- Manual Input Collapse Section --}}
                    <div class="collapse mt-3 text-start" id="manual-location-collapse">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold mb-2 text-dark"><i class="bi bi-geo me-1"></i> Input Koordinat Manual / Pilih Lokasi</h6>

                            {{-- Quick Presets --}}
                            <div class="mb-3">
                                <span class="small text-muted me-2">Preset Lokasi Cepat:</span>
                                <button type="button" class="preset-btn me-1 mb-1" onclick="setPreset(-8.2192, 114.3692)">Banyuwangi Kota</button>
                                <button type="button" class="preset-btn me-1 mb-1" onclick="setPreset(-8.4321, 114.3411)">Muncar</button>
                                <button type="button" class="preset-btn me-1 mb-1" onclick="setPreset(-8.3713, 113.4740)">Puger (Jember)</button>
                                <button type="button" class="preset-btn me-1 mb-1" onclick="setPreset(-7.7154, 114.2793)">Mimbo (Situbondo)</button>
                            </div>

                            <form id="form-manual" onsubmit="handleManualSearch(event)">
                                <div class="row g-2">
                                    <div class="col-sm-5">
                                        <label class="form-label small fw-medium mb-1">Latitude</label>
                                        <input type="text" id="manual-lat" class="form-control form-control-sm" placeholder="Contoh: -8.2192" required>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="form-label small fw-medium mb-1">Longitude</label>
                                        <input type="text" id="manual-lng" class="form-control form-control-sm" placeholder="Contoh: 114.3692" required>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-medium">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Loading Indicator --}}
                    <div id="state-loading" class="mt-4 d-none">
                        <div class="spinner-border text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted fw-medium" id="loading-text">Mendeteksi lokasi Anda...</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Error State Card --}}
        <div id="state-error" class="row justify-content-center d-none mb-4">
            <div class="col-lg-8">
                <div class="alert alert-warning d-flex align-items-start rounded-4 p-4 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning flex-shrink-0 mt-1"></i>
                    <div>
                        <h5 class="alert-heading fw-bold mb-1">Gagal Mengambil Lokasi Otomatis Browser</h5>
                        <p class="mb-2" id="error-message">Terjadi kesalahan saat meminta akses lokasi GPS browser.</p>
                        <hr class="my-2">
                        <p class="mb-0 small text-dark">
                            <strong>Solusi:</strong> Gunakan opsi
                            <button type="button" class="btn btn-sm btn-link p-0 align-baseline fw-bold text-primary" onclick="openManualCollapse()">Input Koordinat Manual</button>
                            di atas atau pilih salah satu preset lokasi cepat.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Empty State Card --}}
        <div id="state-empty" class="row justify-content-center d-none">
            <div class="col-lg-8 text-center">
                <div class="bg-white p-5 rounded-4 shadow-sm">
                    <i class="bi bi-search-heart text-muted display-4 mb-3 d-block"></i>
                    <h4 class="fw-bold">Tidak Ada TPI Ditemukan</h4>
                    <p class="text-muted mb-0">
                        Saat ini belum ada lokasi TPI aktif yang memiliki data koordinat terdaftar di sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- Data State / Results Grid --}}
        <div id="state-results" class="d-none">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-navy">
                    <i class="bi bi-list-stars text-primary me-2"></i>Hasil TPI Terdekat
                </h4>
                <span class="badge bg-secondary rounded-pill fs-6 px-3 py-2" id="total-results">0 TPI</span>
            </div>

            <div class="row g-4" id="tpi-list-container">
                {{-- Dynamic TPI Cards will be rendered here --}}
            </div>
        </div>

    </div>
</section>

{{-- FITUR BARU: Modal untuk menampilkan daftar produk yang sedang dilelang di sebuah TPI --}}
<div class="modal fade" id="modal-lelang" tabindex="-1" aria-labelledby="modal-lelang-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modal-lelang-label">
                    <i class="bi bi-hammer text-primary me-2"></i>Produk Sedang Dilelang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Loading state modal --}}
                <div id="modal-lelang-loading" class="text-center py-5">
                    <div class="spinner-border text-primary mb-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Memuat daftar produk lelang...</p>
                </div>

                {{-- Error state modal --}}
                <div id="modal-lelang-error" class="alert alert-danger d-none mb-0" role="alert"></div>

                {{-- Empty state modal --}}
                <div id="modal-lelang-empty" class="text-center py-5 d-none">
                    <i class="bi bi-inbox text-muted display-5 mb-3 d-block"></i>
                    <p class="text-muted mb-0">Belum ada produk yang sedang dilelang di TPI ini saat ini.</p>
                </div>

                {{-- List produk lelang --}}
                <div id="modal-lelang-list" class="d-flex flex-column gap-3 d-none"></div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openManualCollapse() {
        const collapseEl = document.getElementById('manual-location-collapse');
        if (collapseEl && typeof bootstrap !== 'undefined') {
            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl);
            bsCollapse.show();
        }
    }

    function setPreset(lat, lng) {
        document.getElementById('manual-lat').value = lat;
        document.getElementById('manual-lng').value = lng;
        openManualCollapse();
        fetchTpiTerdekat(lat, lng);
    }

    function handleManualSearch(e) {
        e.preventDefault();
        const latVal = document.getElementById('manual-lat').value;
        const lngVal = document.getElementById('manual-lng').value;
        const lat = parseFloat(latVal);
        const lng = parseFloat(lngVal);

        if (isNaN(lat) || isNaN(lng)) {
            showError('Mohon masukkan angka koordinat latitude (-90 s/d 90) dan longitude (-180 s/d 180) yang valid.');
            return;
        }

        fetchTpiTerdekat(lat, lng);
    }

    /**
     * FIX: entry point GPS.
     * - Cek dukungan geolocation & wajib HTTPS terlebih dahulu.
     * - Delegasikan pengambilan posisi ke requestPosition() yang punya retry/fallback.
     */
    function getLocation() {
        const btnLocation = document.getElementById('btn-location');
        const stateLoading = document.getElementById('state-loading');
        const loadingText = document.getElementById('loading-text');
        const stateError = document.getElementById('state-error');
        const stateEmpty = document.getElementById('state-empty');
        const stateResults = document.getElementById('state-results');

        // Reset states
        stateError.classList.add('d-none');
        stateEmpty.classList.add('d-none');
        stateResults.classList.add('d-none');

        if (!navigator.geolocation) {
            showError('Browser Anda tidak mendukung fitur Geolocation. Silakan gunakan opsi Input Koordinat Manual.');
            return;
        }

        // FIX: Geolocation API browser modern wajib HTTPS (kecuali localhost).
        // Kalau diakses via HTTP, browser bisa menolak/gagal tanpa pesan jelas.
        if (location.protocol !== 'https:' && !['localhost', '127.0.0.1'].includes(location.hostname)) {
            showError('Fitur GPS hanya berfungsi di koneksi HTTPS. Silakan gunakan opsi Input Koordinat Manual di bawah.');
            return;
        }

        btnLocation.disabled = true;
        stateLoading.classList.remove('d-none');
        loadingText.textContent = 'Mendeteksi lokasi Anda...';

        requestPosition(true); // percobaan pertama: mode akurat (GPS)
    }

    /**
     * FIX: fungsi baru untuk retry.
     * Percobaan 1: enableHighAccuracy true, timeout pendek (8 detik) — biasanya cepat dapat sinyal GPS asli di HP.
     * Kalau timeout/posisi tidak tersedia, otomatis fallback ke percobaan 2:
     * enableHighAccuracy false, timeout lebih panjang (20 detik) — pakai WiFi/IP based location,
     * cocok untuk laptop/desktop tanpa chip GPS.
     */
    function requestPosition(tryHighAccuracy) {
        const btnLocation = document.getElementById('btn-location');
        const stateLoading = document.getElementById('state-loading');
        const loadingText = document.getElementById('loading-text');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                btnLocation.disabled = false;
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                loadingText.textContent = 'Mencari TPI terdekat dari koordinat Anda...';
                fetchTpiTerdekat(lat, lng);
            },
            function(error) {
                // FIX: kalau percobaan pertama (high accuracy) timeout atau posisi tidak tersedia,
                // jangan langsung menyerah — coba lagi dengan mode low-accuracy.
                if (tryHighAccuracy && (error.code === error.TIMEOUT || error.code === error.POSITION_UNAVAILABLE)) {
                    loadingText.textContent = 'Mencoba metode deteksi lokasi lain...';
                    requestPosition(false);
                    return;
                }

                btnLocation.disabled = false;
                stateLoading.classList.add('d-none');

                let errorMsg = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = 'Izin akses lokasi ditolak oleh browser Anda. Silakan gunakan opsi Input Koordinat Manual di bawah.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = 'Informasi lokasi perangkat Anda tidak tersedia. Pastikan Location Services aktif di perangkat/OS Anda, atau gunakan Input Koordinat Manual.';
                        break;
                    case error.TIMEOUT:
                        errorMsg = 'Waktu permintaan lokasi telah habis (timeout). Silakan gunakan opsi Input Koordinat Manual di bawah.';
                        break;
                    default:
                        errorMsg = 'Terjadi kesalahan saat meminta akses lokasi. Silakan gunakan opsi Input Koordinat Manual.';
                        break;
                }
                showError(errorMsg);
            },
            tryHighAccuracy
                ? { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
                : { enableHighAccuracy: false, timeout: 20000, maximumAge: 60000 }
        );
    }

    function fetchTpiTerdekat(lat, lng) {
        const btnLocation = document.getElementById('btn-location');
        const stateLoading = document.getElementById('state-loading');
        const stateEmpty = document.getElementById('state-empty');
        const stateResults = document.getElementById('state-results');
        const stateError = document.getElementById('state-error');
        const container = document.getElementById('tpi-list-container');
        const totalBadge = document.getElementById('total-results');

        stateError.classList.add('d-none');
        stateEmpty.classList.add('d-none');
        stateLoading.classList.remove('d-none');

        const url = `{{ route('tpi.terdekat-json') }}?latitude=${lat}&longitude=${lng}`;

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data dari server.');
            }
            return response.json();
        })
        .then(res => {
            if (btnLocation) btnLocation.disabled = false;
            stateLoading.classList.add('d-none');

            if (res.status === 'success' && res.data && res.data.length > 0) {
                container.innerHTML = '';
                totalBadge.textContent = `${res.data.length} TPI Ditemukan`;

                res.data.forEach(tpi => {
                    // Badge status lelang aktif, dibaca dari field `lelang_aktif_count`
                    // (dikirim dari TpiController::getTerdekatJson via withCount)
                    const jumlahLelang = parseInt(tpi.lelang_aktif_count || 0);
                    const adaLelang = jumlahLelang > 0;

                    const lelangBadgeHtml = adaLelang
                        ? `<span class="lelang-badge is-active">
                               <span class="pulse-dot"></span> ${jumlahLelang} Lelang Aktif
                           </span>`
                        : `<span class="lelang-badge is-inactive">
                               <i class="bi bi-moon"></i> Tidak Ada Lelang
                           </span>`;

                    const tombolLelangHtml = adaLelang
                        ? `<button type="button"
                                   class="btn btn-warning btn-sm rounded-pill w-100 fw-medium mt-2"
                                   onclick="lihatLelang(${tpi.id}, '${escapeHtml(tpi.name).replace(/'/g, "\\'")}')">
                               <i class="bi bi-hammer me-1"></i> Lihat Lelang
                           </button>`
                        : `<button type="button" class="btn btn-outline-secondary btn-sm rounded-pill w-100 fw-medium mt-2" disabled>
                               <i class="bi bi-hammer me-1"></i> Tidak Ada Lelang
                           </button>`;

                    const cardHtml = `
                        <div class="col-md-6 col-lg-4">
                            <div class="card tpi-card p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-bold mb-0 text-dark">${escapeHtml(tpi.name)}</h5>
                                    <span class="distance-badge">
                                        <i class="bi bi-geo text-primary"></i> ${tpi.jarak_km} km
                                    </span>
                                </div>
                                <div class="mb-2">
                                    ${lelangBadgeHtml}
                                </div>
                                <hr class="my-2 text-muted opacity-25">
                                <div class="card-body px-0 py-2">
                                    <p class="text-muted mb-2 small">
                                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                                        ${tpi.alamat ? escapeHtml(tpi.alamat) : '<em>Alamat belum diisi</em>'}
                                    </p>
                                    <p class="text-muted mb-3 small">
                                        <i class="bi bi-telephone me-2 text-primary"></i>
                                        ${tpi.phone ? escapeHtml(tpi.phone) : '<em>Nomor telepon belum diisi</em>'}
                                    </p>
                                </div>
                                <div class="mt-auto pt-2">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination=${tpi.latitude},${tpi.longitude}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-medium">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Rute di Google Maps
                                    </a>
                                    ${tombolLelangHtml}
                                </div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', cardHtml);
                });

                stateResults.classList.remove('d-none');
            } else {
                stateEmpty.classList.remove('d-none');
            }
        })
        .catch(err => {
            if (btnLocation) btnLocation.disabled = false;
            stateLoading.classList.add('d-none');
            showError(err.message || 'Terjadi kesalahan jaringan saat menghubungi server.');
        });
    }

    /**
     * FIX: URL diganti dari /tpi/{id}/lelang-aktif-json ke /tpi/{id}/produk-aktif-json
     * (nama route final di web.php: tpi.produk-aktif-json, controller: ProdukController::produkAktifByTpiJson).
     * FIX: mapping field disesuaikan dengan response controller yang sebenarnya —
     * jenis_ikan (bukan nama_produk), berat (bukan satuan), foto (bukan gambar).
     */
    function lihatLelang(tpiId, tpiName) {
        const modalEl = document.getElementById('modal-lelang');
        const modalLabel = document.getElementById('modal-lelang-label');
        const loadingEl = document.getElementById('modal-lelang-loading');
        const errorEl = document.getElementById('modal-lelang-error');
        const emptyEl = document.getElementById('modal-lelang-empty');
        const listEl = document.getElementById('modal-lelang-list');

        modalLabel.innerHTML = `<i class="bi bi-hammer text-primary me-2"></i>Lelang Aktif — ${escapeHtml(tpiName)}`;

        // reset semua state modal
        loadingEl.classList.remove('d-none');
        errorEl.classList.add('d-none');
        emptyEl.classList.add('d-none');
        listEl.classList.add('d-none');
        listEl.innerHTML = '';

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        fetch(`/tpi/${tpiId}/produk-aktif-json`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data produk lelang dari server.');
            }
            return response.json();
        })
        .then(res => {
            loadingEl.classList.add('d-none');

            if (res.status === 'success' && res.data && res.data.length > 0) {
                res.data.forEach(produk => {
                    const gambarSrc = produk.foto ? produk.foto : 'https://via.placeholder.com/64?text=Ikan';
                    const hargaCurrent = produk.harga_current
                        ? `Rp ${Number(produk.harga_current).toLocaleString('id-ID')}`
                        : `Rp ${Number(produk.harga_awal).toLocaleString('id-ID')} <span class="text-muted small">(harga awal)</span>`;

                    const itemHtml = `
                        <div class="produk-lelang-item">
                            <img src="${gambarSrc}" alt="${escapeHtml(produk.jenis_ikan)}">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1">${escapeHtml(produk.jenis_ikan)}</h6>
                                    <span class="badge bg-danger-subtle text-danger fw-medium">Berlangsung</span>
                                </div>
                                <p class="mb-1 small text-muted">
                                    Berat: ${produk.berat} kg${produk.waktu_selesai ? ' &bull; Berakhir: ' + produk.waktu_selesai : ''}
                                </p>
                                <p class="mb-0 harga-current">${hargaCurrent}</p>
                            </div>
                        </div>
                    `;
                    listEl.insertAdjacentHTML('beforeend', itemHtml);
                });
                listEl.classList.remove('d-none');
            } else {
                emptyEl.classList.remove('d-none');
            }
        })
        .catch(err => {
            loadingEl.classList.add('d-none');
            errorEl.textContent = err.message || 'Terjadi kesalahan saat memuat data lelang.';
            errorEl.classList.remove('d-none');
        });
    }

    function showError(message) {
        const stateError = document.getElementById('state-error');
        const errorMessage = document.getElementById('error-message');
        errorMessage.textContent = message;
        stateError.classList.remove('d-none');
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
@endpush