@extends('layouts.pembeli')

@section('title', 'Jadwal Lelang — Peluang')

@section('page-title', 'Jadwal Lelang')
@section('page-subtitle', 'Daftar jadwal lelang ikan yang akan datang.')

@section('breadcrumb')
    <span>Jadwal Lelang</span>
@endsection

@push('styles')
<style>
    .jadwal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
    }

    .jadwal-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1.4rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        transition: box-shadow .2s, transform .2s;
    }
    .jadwal-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }

    .jadwal-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .jadwal-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        background: #eff6ff;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .jadwal-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
        line-height: 1.3;
    }

    .jadwal-meta {
        display: flex;
        flex-direction: column;
        gap: .45rem;
    }
    .jadwal-meta-row {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .83rem;
        color: #475569;
    }
    .jadwal-meta-row svg {
        width: 14px; height: 14px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .jadwal-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .6rem;
        border-radius: 99px;
        margin-top: .25rem;
        align-self: flex-start;
    }
    .jadwal-badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #22c55e;
        animation: pulse 1.4s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

    .jadwal-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
        background: #fff;
        border-radius: 12px;
        border: 1px dashed #e2e8f0;
    }
    .jadwal-empty svg {
        width: 48px; height: 48px;
        margin: 0 auto .75rem;
        color: #cbd5e1;
    }
    .jadwal-empty p { font-size: .95rem; }
</style>
@endpush

@section('content')

@if($jadwals->isEmpty())
    <div class="jadwal-empty">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p>Belum ada jadwal lelang yang tersedia saat ini.</p>
    </div>
@else
    <div class="jadwal-grid">
        @foreach($jadwals as $jadwal)
            <div class="jadwal-card">
                <div class="jadwal-card-header">
                    <div class="jadwal-icon">🐟</div>
                    <div class="jadwal-card-title">{{ $jadwal->nama_barang }}</div>
                </div>

                <div class="jadwal-meta">
                    <div class="jadwal-meta-row">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_lelang)->translatedFormat('d F Y') }}
                    </div>
                    <div class="jadwal-meta-row">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB
                    </div>
                    <div class="jadwal-meta-row">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $jadwal->lokasi }}
                    </div>
                </div>

                <span class="jadwal-badge">Akan datang</span>
            </div>
        @endforeach
    </div>
@endif

@endsection
