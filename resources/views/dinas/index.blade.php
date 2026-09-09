@extends('layouts.navigasi')

@section('title', 'Manajemen Dinas')
@section('page-title', 'Manajemen Dinas')
@section('page-subtitle', 'Kelola data dinas yang terdaftar pada sistem')
@section('content')

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Alert sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-end">
                        <a href="{{ route('dinas.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Dinas
                        </a>
                    </div>

                    @if($dinas->isEmpty())
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>Belum ada data dinas.</div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Dinas</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Jumlah TPI</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dinas as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->name }}</div>
                                                @if ($item->alamat)
                                                    <div class="text-muted small">{{ Str::limit($item->alamat, 40) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->jumlah_tpi }} TPI</span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $item->status ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('dinas.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <form action="{{ route('dinas.toggle-status', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-sm {{ $item->status ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                            onclick="return confirm('Yakin ubah status dinas ini?')">
                                                            <i class="bi {{ $item->status ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                                                            {{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}
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
                        @if ($dinas->hasPages())
                            <div class="mt-4">
                                {{ $dinas->links() }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
