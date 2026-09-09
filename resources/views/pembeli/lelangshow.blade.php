@extends('layouts.navigasi')

@section('title', 'Halaman Penawaran — Peluang')
@section('page-title', 'Halaman Penawaran')
@section('page-subtitle', 'Lakukan Penawaran dengan Pembeli lain')

    @php
    // Pemenang utama (rank 1) dan cadangan (rank 2)
    $pemenang1 = $produk->penawaran->sortByDesc('jumlah_penawaran')->first();
    $pemenang2 = $produk->penawaran->sortByDesc('jumlah_penawaran')->skip(1)->first();

    $pemenang1UserId = $pemenang1?->user_id;
    $pemenang2UserId = $pemenang2?->user_id;

    $pemenang1Nama = $pemenang1?->user?->name;
    $pemenang2Nama = $pemenang2?->user?->name;

    $hargaTertinggi = $pemenang1 ? number_format($pemenang1->jumlah_penawaran, 0, ',', '.') : number_format($produk->harga_awal, 0, ',', '.');
    @endphp

@section('content')

    <div class="py-12"
        data-show-pemenang-utama="{{ Auth::id() === $pemenang1UserId && $pemenang1 && $pemenang1->status === 'belum' && now()->gt($produk->waktu_selesai) ? '1' : '0' }}"
        data-show-pemenang-utama-gugur="{{ Auth::id() === $pemenang1UserId && $pemenang1 && $pemenang1->status === 'gugur' && now()->gt($produk->waktu_selesai->copy()->addMinutes(2)) ? '1' : '0' }}"
        data-show-pemenang-kedua="{{ Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'belum' && $pemenang1 && $pemenang1->status === 'gugur' && now()->gt($produk->waktu_selesai->copy()->addMinutes(2)) ? '1' : '0' }}"
        data-show-pemenang-kedua-gugur="{{ Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'gugur' && now()->gt($produk->waktu_gugur_pemenang1->copy()->addMinutes(2)) ? '1' : '0' }}"
        data-show-cadangan="{{ Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'cadangan' && $pemenang1 && $pemenang1->status !== 'sudah' && now()->gt($produk->waktu_selesai) && now()->lte($produk->waktu_selesai->copy()->addMinutes(2)) ? '1' : '0' }}"
        data-show-kalah="{{ (Auth::id() !== $pemenang1UserId && Auth::id() !== $pemenang2UserId && now()->gt($produk->waktu_selesai)) ? '1' : '0' }}">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container my-5">
                    <div class="row g-4">

                        <!-- Kolom Kiri: Detail Produk -->
                        <div class="col-12 col-lg-6 order-2 order-lg-1">
                            <div class="card shadow rounded-4 mb-4">
                                <div class="card-header bg-primary text-white text-center rounded-top-4">
                                    <h4>Detail Pelelangan</h4>
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-2">Jenis Ikan: <strong>{{ $produk->jenis_ikan }}</strong></h5>
                                    <p>Berat: <strong>{{ $produk->berat }} kg</strong></p>
                                    <hr>
                                    <h6 class="mt-3">Harga Awal:</h6>
                                    <p class="fs-5 fw-bold text-danger">Rp {{ number_format($produk->harga_awal, 0, ',', '.') }}</p>

                                    <h6>Harga Saat Ini:</h6>
                                    <p class="fs-4 fw-bold text-success" id="harga-sekarang">
                                        Rp {{ $hargaTertinggi }}
                                    </p>

                                    <h6>Pemenang Saat Ini:</h6>
                                    <p class="fw-semibold text-primary">{{ $pemenang1Nama ?? '-' }}</p>

                                    <h6>Waktu Selesai:</h6>
                                    <p id="waktu-selesai" data-timestamp="{{ $produk->waktu_selesai?->timestamp * 1000 }}">
                                        {{ $produk->waktu_selesai ?? '-' }}
                                    </p>

                                    {{-- Countdown untuk pemenang utama --}}
                                    @if(Auth::id() === $pemenang1UserId &&
                                    $produk->waktu_selesai &&
                                    $pemenang1 && $pemenang1->status === 'belum' &&
                                    now()->gt($produk->waktu_selesai))
                                    <div class="alert alert-info mt-3 text-center fw-semibold">
                                        Waktu tersisa pembayaran: <span id="countdown" data-timestamp="{{ $produk->waktu_selesai->timestamp * 1000 }}"></span>
                                    </div>
                                    @endif

                                    {{-- Countdown untuk pemenang kedua --}}
                                    @if(Auth::id() === $pemenang2UserId &&
                                    $pemenang1 && $pemenang1->status === 'gugur' &&
                                    $pemenang2 && $pemenang2->status === 'belum' &&
                                    $produk->waktu_gugur_pemenang1)
                                    <div class="alert alert-info mt-3 text-center fw-semibold">
                                        Waktu tersisa pembayaran: <span id="countdown-2" data-timestamp="{{ $produk->waktu_gugur_pemenang1->timestamp * 1000 }}"></span>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            {{-- Form Penawaran --}}
                            @if($produk->waktu_selesai && now()->between($produk->waktu_mulai, $produk->waktu_selesai))
                            <div class="card shadow rounded-4">
                                <div class="card-body">
                                    <h5 class="card-title">Ajukan Tawaran Baru</h5>

                                    @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    <form action="{{ route('penawaran.store', $produk->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="hargaTawaran" class="form-label">Nominal Tawaran (Rp)</label>
                                            <input type="number" name="jumlah_penawaran" class="form-control" id="hargaTawaran" placeholder="Misal: 2200000" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-secondary rounded-pill">Tawar Sekarang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-warning mt-3">
                                Lelang sudah selesai.
                            </div>

                            {{-- Pemenang Utama --}}
                            @if(Auth::id() === $pemenang1UserId && $pemenang1)
                            @if($pemenang1->status === 'belum' && now()->between($produk->waktu_selesai, $produk->waktu_selesai->copy()->addMinutes(2)))
                            <div class="d-grid mt-2">
                                <a href="{{ route('lelang.pembayaran', $produk->id) }}" class="btn btn-primary rounded-pill">
                                    Lakukan Pembayaran
                                </a>
                            </div>
                            @elseif($pemenang1->status === 'belum' && now()->gt($produk->waktu_selesai->copy()->addMinutes(2)))
                            <p class="text-danger text-center fw-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @elseif($pemenang1->status === 'gugur')
                            <p class="text-danger text-center fw-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @endif
                            @endif

                            {{-- Pemenang Kedua --}}
                            @if(Auth::id() === $pemenang2UserId && $pemenang2)
                            @if($pemenang1 && $pemenang1->status === 'gugur' && $pemenang2->status === 'belum' && now()->lte($produk->waktu_gugur_pemenang1->copy()->addMinutes(2)))
                            <div class="alert alert-success mt-3 text-center fw-semibold">
                                🎉 Pemenang utama gugur, sekarang giliran Anda melakukan pembayaran!
                            </div>
                            <div class="d-grid mt-2">
                                <a href="{{ route('lelang.pembayaran', $produk->id) }}" class="btn btn-success rounded-pill">
                                    Lanjutkan Pembayaran
                                </a>
                            </div>
                            @elseif($pemenang2->status === 'gugur')
                            <p class="text-danger text-center fw-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @elseif($pemenang2->status === 'cadangan')
                            @if($pemenang1 && $pemenang1->status === 'sudah')
                            <div class="alert alert-secondary mt-3 text-center fw-semibold">
                                Pemenang utama telah melakukan pembayaran, terimakasih telah berpartisipasi...
                            </div>
                            @else
                            <div class="alert alert-warning mt-3 text-center fw-semibold">
                                Anda adalah pemenang cadangan. Tunggu jika pemenang utama gagal membayar.
                            </div>
                            @endif
                            @elseif($pemenang2->status === 'sudah')
                            <div class="alert alert-info mt-3 text-center fw-semibold">
                                Anda sudah melakukan pembayaran. 🎉
                            </div>
                            @endif
                            @endif


                            {{-- Peserta lain --}}
                            @if(Auth::id() !== $pemenang1UserId && Auth::id() !== $pemenang2UserId)
                            <div class="alert alert-secondary mt-3 text-center">
                                Lelang sudah selesai. Anda tidak menang.
                            </div>
                            @endif
                            @endif
                            {{-- === Jika Pemenang 1 sudah bayar === --}}
                            @if($pemenang1 && $pemenang1->status === 'sudah' && Auth::id() === $pemenang1->user_id)
                            <div class="text-center mt-4">
                                <a href="{{ route('lelang.bukti-pembayaran', $produk->id) }}" class="btn btn-success">
                                    <i class="bi bi-receipt"></i> Lihat Bukti Pembayaran
                                </a>
                            </div>

                            {{-- === Jika Pemenang 2 sudah bayar (karena pemenang 1 gugur) === --}}
                            @elseif($pemenang2 && $pemenang2->status === 'sudah' && Auth::id() === $pemenang2->user_id)
                            <div class="text-center mt-4">
                                <a href="{{ route('lelang.bukti-pembayaran', $produk->id) }}" class="btn btn-success">
                                    <i class="bi bi-receipt"></i> Lihat Bukti Pembayaran
                                </a>
                            </div>
                            @endif


                        </div>

                        <!-- Kolom Kanan: Riwayat Penawaran -->
                        <div class="col-12 col-lg-6 order-1 order-lg-2">
                            <div class="card shadow rounded-4 h-100 d-flex flex-column">
                                <div class="card-header bg-primary text-white text-center rounded-top-4">
                                    <h4>Riwayat Penawaran</h4>
                                </div>
                                <div class="card-body flex-grow-1 overflow-auto" style="max-height: 400px;">
                                    <ul class="list-group" id="riwayat-penawaran">
                                        @forelse($produk->penawaran->sortByDesc('jumlah_penawaran') as $penawaran)
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
                                            data-id="{{ $penawaran->id }}">
                                            <div>
                                                Rp {{ number_format($penawaran->jumlah_penawaran, 0, ',', '.') }}<br>
                                                {{-- FIX: pakai class + data-timestamp supaya bisa diperbarui otomatis oleh JS --}}
                                                <small class="text-muted waktu-relatif"
                                                       data-timestamp="{{ $penawaran->created_at->timestamp * 1000 }}">
                                                    {{ $penawaran->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <span class="badge {{ $penawaran->user_id === Auth::id() ? 'bg-success' : 'bg-primary' }} ms-auto mt-2 mt-lg-0">
                                                {{ $penawaran->user->name }}
                                            </span>
                                        </li>
                                        @empty
                                        <li class="list-group-item text-center">Belum ada penawaran.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pemenang Utama --}}
    @if(Auth::id() === $pemenang1UserId && $pemenang1 && $pemenang1->status === 'belum')
    <div class="modal fade" id="modalPemenangUtama" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🎉 Selamat!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Anda adalah pemenang utama! Silakan lanjutkan pembayaran.
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('lelang.pembayaran', $produk->id) }}" class="btn btn-primary">Lanjutkan Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Pemenang Kedua: Cadangan --}}
    @if(Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'cadangan')
    <div class="modal fade" id="modalCadangan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">⚠️ Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Anda adalah pemenang cadangan. Tunggu jika pemenang utama gagal membayar.
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Pemenang Kedua: Menang --}}
    @if(Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'belum' && $pemenang1 && $pemenang1->status === 'gugur')
    <div class="modal fade" id="modalPemenangKedua" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🎉 Selamat!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Anda sekarang pemenang utama! Silakan lanjutkan pembayaran.
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('lelang.pembayaran', $produk->id) }}" class="btn btn-success">Lanjutkan Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Peserta Kalah --}}
    @if(Auth::id() !== $pemenang1UserId && Auth::id() !== $pemenang2UserId)
    <div class="modal fade" id="modalKalah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ℹ️ Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Lelang sudah selesai. Anda tidak menang. Terima kasih telah berpartisipasi.
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Pemenang Utama Gugur --}}
    @if(Auth::id() === $pemenang1UserId && $pemenang1 && $pemenang1->status === 'gugur')
    <div class="modal fade" id="modalPemenangUtamaGugur" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">⚠️ Gagal!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Anda gagal melakukan pembayaran tepat waktu. Status Anda dianggap gugur.
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Pemenang Kedua Gugur --}}
    @if(Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'gugur')
    <div class="modal fade" id="modalPemenangKeduaGugur" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">⚠️ Gagal!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    Anda gagal melakukan pembayaran tepat waktu. Status Anda dianggap gugur.
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Script untuk countdown --}}
    <script>
        function startCountdown(id, timestamp) {
            const countdownEl = document.querySelector(id);
            if (!countdownEl || !timestamp) return;

            const batasPembayaran = timestamp + 2 * 60 * 1000;

            function updateCountdown() {
                const now = Date.now();
                let diff = batasPembayaran - now;

                if (diff <= 0) {
                    countdownEl.textContent = 'Waktu pembayaran telah habis';
                    clearInterval(timer);
                    return;
                }

                const minutes = Math.floor(diff / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);

                countdownEl.textContent = `${minutes} menit ${seconds} detik`;
            }

            updateCountdown();
            const timer = setInterval(updateCountdown, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const countdown1 = document.querySelector('#countdown');
            if (countdown1) startCountdown('#countdown', parseInt(countdown1.dataset.timestamp));

            const countdown2 = document.querySelector('#countdown-2');
            if (countdown2) startCountdown('#countdown-2', parseInt(countdown2.dataset.timestamp));
        });
    </script>

    {{-- FIX BUG 2: Auto-reload tepat saat waktu_selesai habis, --}}
    {{-- supaya Blade menghitung ulang status pemenang & modal ditampilkan tanpa perlu refresh manual --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const waktuSelesaiEl = document.getElementById('waktu-selesai');
            if (waktuSelesaiEl && waktuSelesaiEl.dataset.timestamp) {
                const target = parseInt(waktuSelesaiEl.dataset.timestamp);
                const now = Date.now();
                if (target && target > now) {
                    // Reload otomatis 1 detik setelah lelang berakhir
                    setTimeout(() => {
                        location.reload();
                    }, (target - now) + 1000);
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.py-12');

            if (container.dataset.showPemenangUtama === '1') {
                new bootstrap.Modal(document.getElementById('modalPemenangUtama')).show();
            }
            if (container.dataset.showPemenangUtamaGugur === '1') {
                new bootstrap.Modal(document.getElementById('modalPemenangUtamaGugur')).show();
            }
            if (container.dataset.showPemenangKedua === '1') {
                new bootstrap.Modal(document.getElementById('modalPemenangKedua')).show();
            }
            if (container.dataset.showPemenangKeduaGugur === '1') {
                new bootstrap.Modal(document.getElementById('modalPemenangKeduaGugur')).show();
            }
            if (container.dataset.showCadangan === '1') {
                new bootstrap.Modal(document.getElementById('modalCadangan')).show();
            }
            if (container.dataset.showKalah === '1') {
                new bootstrap.Modal(document.getElementById('modalKalah')).show();
            }
        });
    </script>


    <style>
        #riwayat-penawaran {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>

    {{-- FIX BUG 1: gunakan timestamp asli dari event, bukan teks statis "baru saja" --}}
    <script>
        function formatWaktuRelatif(ts) {
            const detik = Math.floor((Date.now() - ts) / 1000);
            if (detik < 60) return 'baru saja';
            if (detik < 3600) return Math.floor(detik / 60) + ' menit lalu';
            if (detik < 86400) return Math.floor(detik / 3600) + ' jam lalu';
            return Math.floor(detik / 86400) + ' hari lalu';
        }

        // Perbarui semua label waktu relatif setiap 15 detik
        setInterval(() => {
            document.querySelectorAll('.waktu-relatif').forEach(el => {
                const ts = parseInt(el.dataset.timestamp);
                if (ts) el.textContent = formatWaktuRelatif(ts);
            });
        }, 15000);
    </script>

    <script type="module">
        window.Echo.channel('produk.{{ $produk->id }}')
            .listen('.penawaran.baru', (e) => {
                // Cegah duplikasi: skip kalau id ini sudah ada di DOM
                const sudahAda = document.querySelector(`#riwayat-penawaran li[data-id="${e.id}"]`);
                if (sudahAda) return;

                // 1. Update harga saat ini
                document.getElementById('harga-sekarang').textContent = e.jumlah_format;

                // 2. Tambahkan ke riwayat penawaran (paling atas)
                const list = document.getElementById('riwayat-penawaran');
                const kosong = list.querySelector('li.text-center');
                if (kosong) kosong.remove();

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center flex-wrap';
                li.dataset.id = e.id; // penanda unik
                const isSaya = e.user_id === {{ Auth::id() }};

                // FIX: pakai timestamp asli dari payload event (created_at_timestamp)
                // supaya waktu yang tampil akurat & bisa diperbarui otomatis, bukan "baru saja" statis
                const timestamp = e.created_at_timestamp || Date.now();

                li.innerHTML = `
                    <div>
                        ${e.jumlah_format}<br>
                        <small class="text-muted waktu-relatif" data-timestamp="${timestamp}">baru saja</small>
                    </div>
                    <span class="badge ${isSaya ? 'bg-success' : 'bg-primary'} ms-auto mt-2 mt-lg-0">
                        ${e.user_name}
                    </span>
                `;
                list.prepend(li);
            });
    </script>
@endsection