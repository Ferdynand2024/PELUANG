@extends('layouts.navigasi')

@section('title', 'Halaman Lelang — PELUANG')
@section('page-title', 'Halaman Lelang')
@section('page-subtitle', 'Lelang ikan yang sedang berlangsung saat ini')


@push('styles')
<style>
    /* ── Filter Panel ───────────────────────────── */
    .filter-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }

    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .filter-group label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: .4rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .filter-group .input-wrap {
        position: relative;
    }
    .filter-group .input-icon {
        position: absolute;
        left: .75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        width: 15px; height: 15px;
        pointer-events: none;
    }
    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: .6rem .85rem .6rem 2.25rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: .875rem;
        font-family: inherit;
        color: #1e293b;
        background: #f8fafc;
        transition: border-color .15s, box-shadow .15s;
        outline: none;
    }
    .filter-group select { padding-left: .85rem; }
    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #0f1f3d;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(15,31,61,.08);
    }

    .filter-actions {
        display: flex;
        gap: .5rem;
    }

    .btn-search {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .6rem 1.25rem;
        background: #0f1f3d;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: .875rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
        white-space: nowrap;
    }
    .btn-search:hover { background: #162847; }
    .btn-search svg { width: 15px; height: 15px; }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: border-color .15s, color .15s;
    }
    .btn-reset:hover { border-color: #94a3b8; color: #1e293b; }
    .btn-reset svg { width: 14px; height: 14px; }

    /* ── Advanced filter toggle ─────────────────── */
    .filter-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        margin-top: .85rem;
        padding: .3rem 0;
        background: none;
        border: none;
        font-family: inherit;
        font-size: .8rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: color .15s;
    }
    .filter-toggle-btn:hover { color: #0f1f3d; }
    .filter-toggle-btn svg { width: 14px; height: 14px; transition: transform .2s; }
    .filter-toggle-btn.open svg { transform: rotate(180deg); }

    .filter-advanced {
        display: none;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
        margin-top: .75rem;
    }
    .filter-advanced.open { display: block; }

    .adv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    /* ── Result bar ─────────────────────────────── */
    .result-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .5rem;
        margin-bottom: 1.25rem;
    }
    .result-count {
        font-size: .875rem;
        color: #64748b;
    }
    .result-count strong { color: #1e293b; }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .2rem .65rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 99px;
        font-size: .75rem;
        color: #475569;
        font-weight: 500;
    }

    /* ── Product grid ───────────────────────────── */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    /* ── Product card ───────────────────────────── */
    .fish-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        transition: transform .18s, box-shadow .18s;
    }
    .fish-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,.1);
    }

    .fish-card-img {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .fish-card-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .3s;
    }
    .fish-card:hover .fish-card-img img { transform: scale(1.04); }

    .fish-card-status {
        position: absolute;
        top: .65rem; left: .65rem;
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        background: rgba(15,31,61,.75);
        backdrop-filter: blur(4px);
        color: #f0a500;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .07em;
        padding: .25rem .6rem;
        border-radius: 99px;
        border: 1px solid rgba(240,165,0,.35);
    }
    .fish-card-status::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #f0a500;
        animation: pulse 1.4s infinite;
    }

    .fish-card-body {
        padding: 1rem 1.1rem;
        flex: 1;
    }
    .fish-name {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
        margin-bottom: .6rem;
    }

    .fish-meta {
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }
    .fish-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .82rem;
    }
    .fish-meta-label { color: #64748b; }
    .fish-meta-value { font-weight: 600; color: #1e293b; }
    .fish-meta-value.price { color: #0f1f3d; }

    .fish-countdown {
        margin-top: .6rem;
        padding: .45rem .75rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        font-size: .78rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .fish-countdown svg { width: 13px; height: 13px; color: #94a3b8; flex-shrink: 0; }
    .fish-countdown span { font-weight: 600; color: #475569; font-family: 'DM Mono', monospace; }
    .fish-countdown span.ended { color: #ef4444; }

    .fish-desc {
        margin-top: .55rem;
        font-size: .8rem;
        color: #94a3b8;
        line-height: 1.5;
    }

    .fish-card-footer {
        padding: .85rem 1.1rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: .5rem;
        align-items: center;
    }

    .btn-ikuti {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .6rem 1rem;
        background: #f0a500;
        color: #0f1f3d;
        border: none;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 700;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s, transform .1s;
    }
    .btn-ikuti:hover { background: #c4870a; color: #fff; }
    .btn-ikuti:active { transform: scale(.97); }
    .btn-ikuti svg { width: 15px; height: 15px; }

    .btn-selesai {
        display: inline-flex;
        align-items: center;
        padding: .6rem .9rem;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: .82rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-selesai:hover { background: #fecaca; }

    /* ── Empty state ────────────────────────────── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1rem;
        background: #fff;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }
    .empty-state-icon { font-size: 2.5rem; margin-bottom: .75rem; }
    .empty-state h3 { font-size: 1rem; font-weight: 600; color: #475569; margin-bottom: .4rem; }
    .empty-state p  { font-size: .85rem; color: #94a3b8; }
    .empty-state a  { color: #0f1f3d; font-weight: 600; }

    /* ── Responsive ─────────────────────────────── */
    @media (max-width: 900px) {
        .product-grid    { grid-template-columns: repeat(2, 1fr); }
        .filter-row      { grid-template-columns: 1fr 1fr; }
        .filter-actions  { grid-column: 1 / -1; }
        .adv-grid        { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .product-grid    { grid-template-columns: 1fr; }
        .filter-row      { grid-template-columns: 1fr; }
        .adv-grid        { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- ── Filter Panel ─────────────────────────────────────── --}}
<form method="GET" action="{{ route('lelang.index') }}" id="filterForm">
    <div class="filter-panel">

        {{-- Row 1: Search + Sort + Buttons --}}
        <div class="filter-row">

            <div class="filter-group">
                <label>Cari Jenis Ikan</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        placeholder="Contoh: Tuna, Tongkol, Cakalang…"
                        value="{{ request('search') }}"
                        autocomplete="off"
                        list="jenisIkanSuggestions"
                    >
                    <datalist id="jenisIkanSuggestions">
                        @foreach($jenisIkanList as $jenis)
                            <option value="{{ $jenis }}">
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="filter-group">
                <label>Urutkan</label>
                <select name="sort" onchange="document.getElementById('filterForm').submit()">
                    <option value="latest"     {{ request('sort','latest') == 'latest'     ? 'selected' : '' }}>Terbaru</option>
                    <option value="waktu_asc"  {{ request('sort')          == 'waktu_asc'  ? 'selected' : '' }}>Waktu Selesai Terdekat</option>
                    <option value="harga_asc"  {{ request('sort')          == 'harga_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ request('sort')          == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="berat_asc"  {{ request('sort')          == 'berat_asc'  ? 'selected' : '' }}>Berat Teringan</option>
                    <option value="berat_desc" {{ request('sort')          == 'berat_desc' ? 'selected' : '' }}>Berat Terberat</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-search">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    Cari
                </button>
                @if(request()->hasAny(['search','harga_min','harga_max','berat_min','sort']))
                    <a href="{{ route('lelang.index') }}" class="btn-reset" title="Reset filter">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Toggle filter lanjutan --}}
        <button type="button" class="filter-toggle-btn {{ request()->hasAny(['harga_min','harga_max','berat_min']) ? 'open' : '' }}"
                id="btnFilterLanjutan" onclick="toggleFilter()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm3 6h12M6 16h8"/>
            </svg>
            Filter Lanjutan
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" id="chevronIcon">
                <path stroke-linecap="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Advanced filters --}}
        <div class="filter-advanced {{ request()->hasAny(['harga_min','harga_max','berat_min']) ? 'open' : '' }}"
             id="filterAdvanced">
            <div class="adv-grid">
                <div class="filter-group">
                    <label>Harga Awal Min (Rp)</label>
                    <div class="input-wrap">
                        <input type="number" name="harga_min" placeholder="0" min="0"
                               value="{{ request('harga_min') }}" style="padding-left:.85rem">
                    </div>
                </div>
                <div class="filter-group">
                    <label>Harga Awal Max (Rp)</label>
                    <div class="input-wrap">
                        <input type="number" name="harga_max" placeholder="Tidak terbatas" min="0"
                               value="{{ request('harga_max') }}" style="padding-left:.85rem">
                    </div>
                </div>
                <div class="filter-group">
                    <label>Berat Minimum (kg)</label>
                    <div class="input-wrap">
                        <input type="number" name="berat_min" placeholder="0" min="0" step="0.1"
                               value="{{ request('berat_min') }}" style="padding-left:.85rem">
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

{{-- ── Result bar ───────────────────────────────────────── --}}
<div class="result-bar">
    <p class="result-count">
        Menampilkan <strong>{{ $produk->count() }}</strong> produk lelang
        @if(request('search'))untuk "<strong>{{ request('search') }}</strong>"@endif
    </p>
    <div class="active-filters">
        @if(request('harga_min'))
            <span class="filter-badge">Harga ≥ Rp{{ number_format(request('harga_min'),0,',','.') }}</span>
        @endif
        @if(request('harga_max'))
            <span class="filter-badge">Harga ≤ Rp{{ number_format(request('harga_max'),0,',','.') }}</span>
        @endif
        @if(request('berat_min'))
            <span class="filter-badge">Berat ≥ {{ request('berat_min') }} kg</span>
        @endif
    </div>
</div>

{{-- ── Product Grid ─────────────────────────────────────── --}}
<div class="product-grid">
    @forelse($produk as $item)
        <div class="fish-card">

            <div class="fish-card-img">
                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/400x250?text=No+Image' }}"
                     alt="{{ $item->jenis_ikan }}">
                <span class="fish-card-status">BERLANGSUNG</span>
            </div>

            <div class="fish-card-body">
                <div class="fish-name">{{ $item->jenis_ikan }}</div>

                <div class="fish-meta">
                    <div class="fish-meta-row">
                        <span class="fish-meta-label">Berat</span>
                        <span class="fish-meta-value">{{ $item->berat }} kg</span>
                    </div>
                    <div class="fish-meta-row">
                        <span class="fish-meta-label">Harga Awal</span>
                        <span class="fish-meta-value price">Rp{{ number_format($item->harga_awal,0,',','.') }}</span>
                    </div>
                </div>

                @if($item->waktu_selesai)
                <div class="fish-countdown">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" d="M12 6v6l4 2"/>
                    </svg>
                    <span id="countdown-{{ $item->id }}"
                          data-timestamp="{{ $item->waktu_selesai->timestamp * 1000 }}">
                    </span>
                </div>
                @endif

                @if($item->deskripsi)
                <p class="fish-desc">{{ Str::limit($item->deskripsi, 80) }}</p>
                @endif
            </div>

            <div class="fish-card-footer">
                <a href="{{ route('lelang.show', $item->id) }}" class="btn-ikuti">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Ikuti Lelang
                </a>

                @if(auth()->check() && auth()->user()->isAdmin() && $item->status_lelang == 'dibuka')
                    <form action="{{ route('lelang.selesai', $item->id) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="btn-selesai"
                                onclick="return confirm('Akhiri lelang produk ini?')">
                            Selesai
                        </button>
                    </form>
                @endif
            </div>

        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">🐟</div>
            @if(request()->hasAny(['search','harga_min','harga_max','berat_min']))
                <h3>Tidak ada hasil</h3>
                <p>Tidak ada produk yang cocok dengan filter. <a href="{{ route('lelang.index') }}">Hapus filter</a></p>
            @else
                <h3>Belum ada lelang aktif</h3>
                <p>Belum ada produk yang tersedia untuk dilelang saat ini.</p>
            @endif
        </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
    // Toggle filter lanjutan
    function toggleFilter() {
        const panel   = document.getElementById('filterAdvanced');
        const btn     = document.getElementById('btnFilterLanjutan');
        const isOpen  = panel.classList.contains('open');
        panel.classList.toggle('open', !isOpen);
        btn.classList.toggle('open', !isOpen);
    }

    // Countdown timer
    function updateCountdown() {
        document.querySelectorAll('[id^="countdown-"]').forEach(el => {
            const diff = parseInt(el.dataset.timestamp) - Date.now();
            if (diff > 0) {
                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000)  / 60000);
                const s = Math.floor((diff % 60000)    / 1000);
                let t = '';
                if (d > 0) t += d + ' hari ';
                if (h > 0) t += h + ' jam ';
                t += m + ' mnt ' + String(s).padStart(2, '0') + ' dtk';
                el.textContent = t;
                el.classList.remove('ended');
            } else {
                el.textContent = 'Lelang Selesai';
                el.classList.add('ended');
            }
        });
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // Submit on Enter di search
    document.getElementById('searchInput')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); document.getElementById('filterForm').submit(); }
    });
</script>
@endpush