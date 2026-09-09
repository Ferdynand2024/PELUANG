@extends('layouts.navigasi')

@section('title', Auth::user()->isDinas() ? 'TPI Saya' : 'Manajemen TPI')
@section('page-title', Auth::user()->isDinas() ? 'TPI Saya' : 'Manajemen TPI')
@section('page-subtitle', 'Kelola data Tempat Pelelangan Ikan (TPI) yang terdaftar')
@section('content')

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-end">
                        <a href="{{ route('tpi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah TPI
                        </a>
                    </div>

                    @if($tpiList->isEmpty())
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>Belum ada data TPI.</div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama TPI</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        @if(Auth::user()->isAdmin())
                                            <th>Dinas</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tpiList as $tpi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $tpi->name }}</div>
                                                @if ($tpi->alamat)
                                                    <div class="text-muted small">{{ Str::limit($tpi->alamat, 40) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $tpi->email }}</td>
                                            <td>{{ $tpi->phone ?? '-' }}</td>
                                            @if(Auth::user()->isAdmin())
                                                <td>
                                                    @if($tpi->dinas)
                                                        <span class="badge bg-info-subtle text-info-emphasis">
                                                            {{ $tpi->dinas->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted fst-italic">Tidak ada</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <span class="badge {{ $tpi->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $tpi->status ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('tpi.edit', $tpi->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <form action="{{ route('tpi.toggle-status', $tpi->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-sm {{ $tpi->status ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                            onclick="return confirm('Yakin ubah status TPI ini?')">
                                                            <i class="bi {{ $tpi->status ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                                                            {{ $tpi->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($tpiList->hasPages())
                            <div class="mt-4">
                                {{ $tpiList->links() }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
