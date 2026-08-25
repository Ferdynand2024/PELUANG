@extends('layouts.navigasi')

@section('title', 'Halaman Produk — PELUANG')
@section('page-title', 'Daftar Produk')
@section('page-subtitle', 'Kelola produk ikan yang akan dilelang')

@push('styles')
<style>
    .produk-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }

    .produk-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .produk-toolbar h3 {
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

    /* ── Table ──────────────────────────────────── */
    .produk-table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
    table.produk-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }
    .produk-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        text-align: left;
        padding: .8rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .produk-table thead th:last-child { text-align: right; }
    .produk-table tbody td {
        padding: .75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .produk-table tbody tr:last-child td { border-bottom: none; }
    .produk-table tbody tr:hover { background: #f8fafc; }

    .produk-thumb {
        height: 56px;
        width: 84px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        display: block;
        transition: transform .15s;
    }
    .produk-thumb:hover { transform: scale(1.04); }
    .no-foto {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 56px;
        width: 84px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: .7rem;
        font-weight: 600;
    }

    .produk-nama { font-weight: 700; color: #0f1f3d; }
    .produk-harga { font-weight: 600; color: #0f1f3d; }
    .produk-desc {
        max-width: 220px;
        color: #64748b;
        font-size: .8rem;
        line-height: 1.4;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .25rem .65rem;
        border-radius: 99px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .status-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
    }
    .status-belum { background: #f1f5f9; color: #475569; }
    .status-belum::before { background: #94a3b8; }
    .status-dibuka { background: #fff7e6; color: #c4870a; }
    .status-dibuka::before { background: #f0a500; }
    .status-ditutup { background: #fee2e2; color: #991b1b; }
    .status-ditutup::before { background: #ef4444; }

    .countdown-cell {
        font-family: 'DM Mono', monospace;
        font-size: .78rem;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .produk-actions {
        display: flex;
        gap: .75rem;
        justify-content: flex-end;
        align-items: center;
        white-space: nowrap;
    }
    .produk-actions a,
    .produk-actions button {
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        background: none;
        border: none;
        font-family: inherit;
        cursor: pointer;
        transition: opacity .15s;
        padding: 0;
    }
    .produk-actions a:hover,
    .produk-actions button:hover { opacity: .7; }
    .link-mulai   { color: #16a34a; }
    .link-selesai { color: #ef4444; }
    .link-edit    { color: #c4870a; }
    .link-hapus   { color: #ef4444; }
    .link-lihat   { color: #0f1f3d; }

    /* ── Lightbox ───────────────────────────────── */
    .full-image-container {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(15,31,61,.92);
        z-index: 10000;
        justify-content: center;
        align-items: center;
    }
    .full-image-container img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')

<div class="produk-panel">

    <div class="produk-toolbar">
        <h3>Semua Produk</h3>
        <a href="{{ route('produk.create') }}" class="btn-tambah">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    <div class="produk-table-wrap">
        <table class="produk-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Jenis Ikan</th>
                    <th>Berat (kg)</th>
                    <th>Harga Awal (Rp)</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Waktu Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $p)
                    <tr>
                        <td>
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}"
                                     alt="{{ $p->jenis_ikan }}"
                                     class="produk-thumb"
                                     onclick="showFullImage(this)">
                            @else
                                <span class="no-foto">No Foto</span>
                            @endif
                        </td>
                        <td class="produk-nama">{{ $p->jenis_ikan }}</td>
                        <td>{{ $p->berat }}</td>
                        <td class="produk-harga">Rp {{ number_format($p->harga_awal, 0, ',', '.') }}</td>
                        <td class="produk-desc">{{ $p->deskripsi }}</td>
                        <td>
                            @if ($p->status_lelang == 'belum_dimulai')
                                <span class="status-badge status-belum">Belum Dimulai</span>
                            @elseif ($p->status_lelang == 'dibuka')
                                <span class="status-badge status-dibuka">Dibuka</span>
                            @elseif ($p->status_lelang == 'ditutup')
                                <span class="status-badge status-ditutup">Ditutup</span>
                            @endif
                        </td>
                        <td class="countdown-cell">
                            @if ($p->status_lelang == 'dibuka' && $p->waktu_selesai)
                                <span id="countdown-admin-{{ $p->id }}" data-timestamp="{{ $p->waktu_selesai->timestamp * 1000 }}"></span>
                            @elseif ($p->waktu_selesai)
                                {{ $p->waktu_selesai->format('d M Y, H:i:s') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="produk-actions">
                                @if ($p->status_lelang == 'belum_dimulai')
                                    <form action="{{ route('lelang.mulai', $p->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="link-mulai">Mulai Lelang</button>
                                    </form>
                                @elseif ($p->status_lelang == 'dibuka')
                                    <form action="{{ route('lelang.selesai', $p->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="link-selesai" onclick="return confirm('Apakah Anda yakin ingin mengakhiri lelang produk ini?')">Selesai Lelang</button>
                                    </form>
                                @endif
                                <a href="{{ route('produk.edit', $p->id) }}" class="link-edit">Edit</a>
                                <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                                <a href="{{ route('produk.penawaran', $p->id) }}" class="link-lihat">Lihat Penawaran</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div id="full-image-container" class="full-image-container" onclick="hideFullImage()">
    <img id="full-image" src="" alt="">
</div>

@endsection

@push('scripts')
<script>
    function showFullImage(img) {
        var container = document.getElementById('full-image-container');
        var fullImg = document.getElementById('full-image');
        fullImg.src = img.src;
        container.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function hideFullImage() {
        var container = document.getElementById('full-image-container');
        container.style.display = 'none';
        document.body.style.overflow = '';
    }

    function updateAdminCountdown() {
        const countdownElements = document.querySelectorAll('[id^="countdown-admin-"]');
        countdownElements.forEach(element => {
            const endTime = parseInt(element.getAttribute('data-timestamp'));
            const now = new Date().getTime();
            const difference = endTime - now;

            if (difference > 0) {
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                let countdownText = "";
                if (days > 0) countdownText += days + " hari ";
                countdownText += hours + " jam " + minutes + " menit " + seconds + " detik";
                element.textContent = countdownText;
            } else {
                element.textContent = "Lelang Selesai";
            }
        });
    }

    setInterval(updateAdminCountdown, 1000);
    updateAdminCountdown();
</script>
@endpush