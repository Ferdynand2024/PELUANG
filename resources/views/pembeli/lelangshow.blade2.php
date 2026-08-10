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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
                <div class="p-4 sm:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Kolom Kiri: Detail Produk -->
                        <div class="order-2 lg:order-1 space-y-6">

                            {{-- Card Detail Pelelangan --}}
                            <div class="rounded-2xl shadow-md overflow-hidden border border-gray-100">
                                <div class="px-6 py-4 text-center text-white" style="background-color:#0f1f3d;">
                                    <h4 class="text-lg font-bold tracking-wide">Detail Pelelangan</h4>
                                </div>
                                <div class="bg-white p-6">
                                    <h5 class="mb-2 text-gray-700">
                                        Jenis Ikan: <strong class="text-gray-900">{{ $produk->jenis_ikan }}</strong>
                                    </h5>
                                    <p class="text-gray-600 mb-3">Berat: <strong class="text-gray-900">{{ $produk->berat }} kg</strong></p>
                                    <hr class="border-gray-200 mb-4">

                                    <h6 class="mt-3 text-sm font-semibold uppercase tracking-wide text-gray-500">Harga Awal</h6>
                                    <p class="text-lg font-bold text-red-600 mb-3">
                                        Rp {{ number_format($produk->harga_awal, 0, ',', '.') }}
                                    </p>

                                    <h6 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Harga Saat Ini</h6>
                                    <p class="text-2xl font-extrabold mb-3" id="harga-sekarang" style="color:#f0a500;">
                                        Rp {{ $hargaTertinggi }}
                                    </p>

                                    <h6 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Pemenang Saat Ini</h6>
                                    <p class="font-semibold mb-3" style="color:#0f1f3d;">{{ $pemenang1Nama ?? '-' }}</p>

                                    <h6 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Waktu Selesai</h6>
                                    <p id="waktu-selesai" class="text-gray-700" data-timestamp="{{ $produk->waktu_selesai?->timestamp * 1000 }}">
                                        {{ $produk->waktu_selesai ?? '-' }}
                                    </p>

                                    {{-- Countdown untuk pemenang utama --}}
                                    @if(Auth::id() === $pemenang1UserId &&
                                    $produk->waktu_selesai &&
                                    $pemenang1 && $pemenang1->status === 'belum' &&
                                    now()->gt($produk->waktu_selesai))
                                    <div class="mt-4 rounded-xl p-4 text-center font-semibold border" style="background-color:#fff8e6; border-color:#f0a500; color:#0f1f3d;">
                                        Waktu tersisa pembayaran: <span id="countdown" data-timestamp="{{ $produk->waktu_selesai->timestamp * 1000 }}"></span>
                                    </div>
                                    @endif

                                    {{-- Countdown untuk pemenang kedua --}}
                                    @if(Auth::id() === $pemenang2UserId &&
                                    $pemenang1 && $pemenang1->status === 'gugur' &&
                                    $pemenang2 && $pemenang2->status === 'belum' &&
                                    $produk->waktu_gugur_pemenang1)
                                    <div class="mt-4 rounded-xl p-4 text-center font-semibold border" style="background-color:#fff8e6; border-color:#f0a500; color:#0f1f3d;">
                                        Waktu tersisa pembayaran: <span id="countdown-2" data-timestamp="{{ $produk->waktu_gugur_pemenang1->timestamp * 1000 }}"></span>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            {{-- Form Penawaran --}}
                            @if($produk->waktu_selesai && now()->between($produk->waktu_mulai, $produk->waktu_selesai))
                            <div class="rounded-2xl shadow-md border border-gray-100 bg-white p-6">
                                <h5 class="text-lg font-bold mb-4" style="color:#0f1f3d;">Ajukan Tawaran Baru</h5>

                                @if($errors->any())
                                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                                    <ul class="mb-0 list-disc list-inside space-y-1">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if(session('success'))
                                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('penawaran.store', $produk->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="hargaTawaran" class="block mb-1 text-sm font-medium text-gray-700">Nominal Tawaran (Rp)</label>
                                        <input type="number" name="jumlah_penawaran" id="hargaTawaran"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2"
                                            style="--tw-ring-color:#f0a500;"
                                            placeholder="Misal: 2200000" required>
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="w-full rounded-full py-2.5 font-semibold text-white transition hover:opacity-90"
                                            style="background-color:#0f1f3d;">
                                            Tawar Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="rounded-xl p-4 text-center font-medium border" style="background-color:#fff8e6; border-color:#f0a500; color:#0f1f3d;">
                                Lelang sudah selesai.
                            </div>

                            {{-- Pemenang Utama --}}
                            @if(Auth::id() === $pemenang1UserId && $pemenang1)
                            @if($pemenang1->status === 'belum' && now()->between($produk->waktu_selesai, $produk->waktu_selesai->copy()->addMinutes(2)))
                            <div class="mt-2">
                                <a href="{{ route('lelang.pembayaran', $produk->id) }}"
                                    class="block text-center w-full rounded-full py-2.5 font-semibold text-white transition hover:opacity-90"
                                    style="background-color:#0f1f3d;">
                                    Lakukan Pembayaran
                                </a>
                            </div>
                            @elseif($pemenang1->status === 'belum' && now()->gt($produk->waktu_selesai->copy()->addMinutes(2)))
                            <p class="text-red-600 text-center font-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @elseif($pemenang1->status === 'gugur')
                            <p class="text-red-600 text-center font-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @endif
                            @endif

                            {{-- Pemenang Kedua --}}
                            @if(Auth::id() === $pemenang2UserId && $pemenang2)
                            @if($pemenang1 && $pemenang1->status === 'gugur' && $pemenang2->status === 'belum' && now()->lte($produk->waktu_gugur_pemenang1->copy()->addMinutes(2)))
                            <div class="mt-3 rounded-xl p-4 text-center font-semibold border border-green-200 bg-green-50 text-green-700">
                                🎉 Pemenang utama gugur, sekarang giliran Anda melakukan pembayaran!
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('lelang.pembayaran', $produk->id) }}"
                                    class="block text-center w-full rounded-full py-2.5 font-semibold text-white transition hover:opacity-90 bg-green-600 hover:bg-green-700">
                                    Lanjutkan Pembayaran
                                </a>
                            </div>
                            @elseif($pemenang2->status === 'gugur')
                            <p class="text-red-600 text-center font-semibold mt-3">
                                Anda gagal melakukan pembayaran tepat waktu. Anda dianggap gugur.
                            </p>
                            @elseif($pemenang2->status === 'cadangan')
                            @if($pemenang1 && $pemenang1->status === 'sudah')
                            <div class="mt-3 rounded-xl p-4 text-center font-semibold border border-gray-200 bg-gray-50 text-gray-600">
                                Pemenang utama telah melakukan pembayaran, terimakasih telah berpartisipasi...
                            </div>
                            @else
                            <div class="mt-3 rounded-xl p-4 text-center font-semibold border" style="background-color:#fff8e6; border-color:#f0a500; color:#0f1f3d;">
                                Anda adalah pemenang cadangan. Tunggu jika pemenang utama gagal membayar.
                            </div>
                            @endif
                            @elseif($pemenang2->status === 'sudah')
                            <div class="mt-3 rounded-xl p-4 text-center font-semibold border border-blue-200 bg-blue-50 text-blue-700">
                                Anda sudah melakukan pembayaran. 🎉
                            </div>
                            @endif
                            @endif

                            {{-- Peserta lain --}}
                            @if(Auth::id() !== $pemenang1UserId && Auth::id() !== $pemenang2UserId)
                            <div class="mt-3 rounded-xl p-4 text-center border border-gray-200 bg-gray-50 text-gray-600">
                                Lelang sudah selesai. Anda tidak menang.
                            </div>
                            @endif
                            @endif

                            {{-- === Jika Pemenang 1 sudah bayar === --}}
                            @if($pemenang1 && $pemenang1->status === 'sudah' && Auth::id() === $pemenang1->user_id)
                            <div class="text-center mt-4">
                                <a href="{{ route('lelang.bukti-pembayaran', $produk->id) }}"
                                    class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 font-semibold text-white transition hover:opacity-90"
                                    style="background-color:#f0a500;">
                                    <i class="bi bi-receipt"></i> Lihat Bukti Pembayaran
                                </a>
                            </div>

                            {{-- === Jika Pemenang 2 sudah bayar (karena pemenang 1 gugur) === --}}
                            @elseif($pemenang2 && $pemenang2->status === 'sudah' && Auth::id() === $pemenang2->user_id)
                            <div class="text-center mt-4">
                                <a href="{{ route('lelang.bukti-pembayaran', $produk->id) }}"
                                    class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 font-semibold text-white transition hover:opacity-90"
                                    style="background-color:#f0a500;">
                                    <i class="bi bi-receipt"></i> Lihat Bukti Pembayaran
                                </a>
                            </div>
                            @endif

                        </div>

                        <!-- Kolom Kanan: Riwayat Penawaran -->
                        <div class="order-1 lg:order-2">
                            <div class="rounded-2xl shadow-md border border-gray-100 bg-white h-full flex flex-col overflow-hidden">
                                <div class="px-6 py-4 text-center text-white" style="background-color:#0f1f3d;">
                                    <h4 class="text-lg font-bold tracking-wide">Riwayat Penawaran</h4>
                                </div>
                                <div class="p-4 flex-grow overflow-auto" style="max-height: 400px;">
                                    <ul class="divide-y divide-gray-100" id="riwayat-penawaran">
                                        @forelse($produk->penawaran->sortByDesc('jumlah_penawaran') as $penawaran)
                                        <li class="flex justify-between items-center flex-wrap gap-2 py-3">
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    Rp {{ number_format($penawaran->jumlah_penawaran, 0, ',', '.') }}
                                                </p>
                                                <small class="text-gray-400">{{ $penawaran->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full text-white
                                                {{ $penawaran->user_id === Auth::id() ? '' : '' }}"
                                                style="background-color: {{ $penawaran->user_id === Auth::id() ? '#f0a500' : '#0f1f3d' }};">
                                                {{ $penawaran->user->name }}
                                            </span>
                                        </li>
                                        @empty
                                        <li class="py-6 text-center text-gray-400">Belum ada penawaran.</li>
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
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white" style="background-color:#0f1f3d;">
                    <h5 class="modal-title font-bold">🎉 Selamat!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
                    Anda adalah pemenang utama! Silakan lanjutkan pembayaran.
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('lelang.pembayaran', $produk->id) }}"
                        class="rounded-full px-5 py-2 font-semibold text-white" style="background-color:#f0a500;">
                        Lanjutkan Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Pemenang Kedua: Cadangan --}}
    @if(Auth::id() === $pemenang2UserId && $pemenang2 && $pemenang2->status === 'cadangan')
    <div class="modal fade" id="modalCadangan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white" style="background-color:#0f1f3d;">
                    <h5 class="modal-title font-bold">⚠️ Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
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
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white" style="background-color:#0f1f3d;">
                    <h5 class="modal-title font-bold">🎉 Selamat!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
                    Anda sekarang pemenang utama! Silakan lanjutkan pembayaran.
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('lelang.pembayaran', $produk->id) }}"
                        class="rounded-full px-5 py-2 font-semibold text-white bg-green-600 hover:bg-green-700">
                        Lanjutkan Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Peserta Kalah --}}
    @if(Auth::id() !== $pemenang1UserId && Auth::id() !== $pemenang2UserId)
    <div class="modal fade" id="modalKalah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white" style="background-color:#0f1f3d;">
                    <h5 class="modal-title font-bold">ℹ️ Informasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
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
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white bg-red-600">
                    <h5 class="modal-title font-bold">⚠️ Gagal!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
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
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header text-white bg-red-600">
                    <h5 class="modal-title font-bold">⚠️ Gagal!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
                    Anda gagal melakukan pembayaran tepat waktu. Status Anda dianggap gugur.
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
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
    @endpush

    @push('scripts')
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
    @endpush


    @push('styles')
    <style>
        #riwayat-penawaran {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    @endpush
@endsection