@extends('layouts.navigasi')

@section('title', 'Laporan Pelelangan TPI Binaan')
@section('page-title', 'Laporan Pelelangan TPI Binaan')
@section('page-subtitle', 'Laporan pelelangan dari seluruh TPI di bawah dinas Anda yang telah dilakukan pembayaran')
@section('content')

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-4">
                        {{-- Form Filter: TPI, Tahun, Bulan, dan Tombol Cari --}}
                        <form action="{{ route('laporan.dinas.index') }}" method="GET" class="row g-3 align-items-end">
                            {{-- Select TPI --}}
                            <div class="col-md-4">
                                <label for="tpi_id" class="form-label">TPI:</label>
                                <select name="tpi_id" id="tpi_id" class="form-select">
                                    <option value="">Semua TPI</option>
                                    @foreach($tpiOptions as $tpi)
                                        <option value="{{ $tpi->id }}" {{ request('tpi_id') == $tpi->id ? 'selected' : '' }}>
                                            {{ $tpi->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Select Tahun --}}
                            <div class="col-md-4">
                                <label for="tahun" class="form-label">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Select Bulan --}}
                            <div class="col-md-4">
                                <label for="bulan" class="form-label">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @php
                                        $months = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                                        ];
                                    @endphp
                                    @foreach($months as $num => $name)
                                        <option value="{{ $num }}" {{ (int) request('bulan') === $num ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> Cari
                                </button>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('laporan.dinas.export', request()->only(['tpi_id', 'tahun', 'bulan'])) }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Export ke Excel
                                </a>
                            </div>
                        </form>
                    </div>

                    @if($produkList->isEmpty())
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>Belum ada data lelang yang selesai dan sudah dibayar sesuai kriteria filter.</div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>TPI</th>
                                        <th>Produk</th>
                                        <th>Pemenang</th>
                                        <th>Harga Akhir</th>
                                        <th>Tanggal Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produkList as $produk)
                                        @foreach ($produk->penawaran as $pemenang)
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}</td>
                                                <td>{{ $produk->tpi->name ?? '-' }}</td>
                                                <td>{{ $produk->jenis_ikan }}</td>
                                                <td>{{ $pemenang->user->name ?? '-' }}</td>
                                                <td>Rp {{ number_format($pemenang->jumlah_penawaran, 0, ',', '.') }}</td>
                                                <td>{{ $produk->waktu_selesai->format('d M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Total Penjualan:</th>
                                        <th colspan="2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
