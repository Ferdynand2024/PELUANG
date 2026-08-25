@extends('layouts.navigasi')

@section('title', 'Halaman Jadwal — PELUANG')
@section('page-title', 'Daftar Jadwal Lelang')
@section('page-subtitle', 'Jadwal lelang ikan yang akan dan sedang berlangsung')

@push('styles')
<style>
    /* ── Panel wrapper ──────────────────────────── */
    .jadwal-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }

    .jadwal-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .jadwal-toolbar h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
    }

    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .6rem 1.1rem;
        background: #0f1f3d;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-tambah:hover { background: #162847; color: #fff; }
    .btn-tambah svg { width: 15px; height: 15px; }

    /* ── Alert ──────────────────────────────────── */
    .alert-success {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 8px;
        padding: .75rem 1rem;
        font-size: .85rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
    }
    .alert-success svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* ── Table ──────────────────────────────────── */
    .jadwal-table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
    table.jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .85rem;
    }
    .jadwal-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        text-align: left;
        padding: .8rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .jadwal-table thead th:last-child { text-align: right; }
    .jadwal-table tbody td {
        padding: .85rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .jadwal-table tbody tr:last-child td { border-bottom: none; }
    .jadwal-table tbody tr:hover { background: #f8fafc; }

    .jadwal-nama { font-weight: 600; color: #0f1f3d; }

    .jadwal-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .2rem .6rem;
        background: #fff7e6;
        border: 1px solid rgba(240,165,0,.35);
        color: #c4870a;
        border-radius: 99px;
        font-size: .72rem;
        font-weight: 700;
    }

    .jadwal-actions {
        display: flex;
        gap: .9rem;
        justify-content: flex-end;
        align-items: center;
    }
    .jadwal-actions a,
    .jadwal-actions button {
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        background: none;
        border: none;
        font-family: inherit;
        cursor: pointer;
        transition: opacity .15s;
    }
    .jadwal-actions a:hover,
    .jadwal-actions button:hover { opacity: .7; }
    .link-lihat  { color: #0f1f3d; }
    .link-edit   { color: #c4870a; }
    .link-hapus  { color: #ef4444; }

    /* ── Empty state ────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    .empty-state-icon { font-size: 2.5rem; margin-bottom: .75rem; }
    .empty-state h4 { font-size: .95rem; font-weight: 600; color: #475569; margin-bottom: .3rem; }
    .empty-state p  { font-size: .82rem; color: #94a3b8; }

    @media (max-width: 640px) {
        .jadwal-toolbar { align-items: flex-start; }
    }
</style>
@endpush

@section('content')

<div class="jadwal-panel">

    <div class="jadwal-toolbar">
        <h3>Semua Jadwal</h3>
        @if (Auth::user()->role == 'tpi')
            <a href="{{ route('jadwal.create') }}" class="btn-tambah">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal Baru
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert-success">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="jadwal-table-wrap">
        <table class="jadwal-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Tanggal Lelang</th>
                    <th>Waktu Mulai</th>
                    <th>Lokasi</th>
                    @if (Auth::user()->role == 'tpi')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $jadwal)
                    <tr>
                        <td class="jadwal-nama">{{ $jadwal->nama_barang }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_lelang)->format('d-m-Y') }}</td>
                        <td><span class="jadwal-badge">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</span></td>
                        <td>{{ $jadwal->lokasi }}</td>
                        @if (Auth::user()->role == 'tpi')
                            <td>
                                <div class="jadwal-actions">
                                    <a href="{{ route('jadwal.show', $jadwal->id) }}" class="link-lihat">Lihat</a>
                                    <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="link-edit">Edit</a>
                                    <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">🗓️</div>
                                <h4>Belum ada jadwal lelang</h4>
                                <p>Jadwal lelang yang dibuat akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection