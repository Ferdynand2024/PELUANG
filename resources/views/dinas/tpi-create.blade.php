@extends('layouts.navigasi')

@section('title', 'Tambah TPI')
@section('page-title', 'Tambah TPI')
@section('page-subtitle', 'Tambahkan data Tempat Pelelangan Ikan (TPI) baru')
@section('content')

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tpi.store') }}">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama TPI <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: TPI Muncar"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="tpi@email.com"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone') }}"
                                class="form-control"
                                placeholder="08xxxxxxxx">
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="form-control"
                                placeholder="Alamat lengkap TPI">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Latitude & Longitude --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitude" name="latitude"
                                    value="{{ old('latitude') }}"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    placeholder="Contoh: -8.2192">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" id="longitude" name="longitude"
                                    value="{{ old('longitude') }}"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    placeholder="Contoh: 114.3692">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pilih Dinas — hanya tampil untuk admin
                             Dinas yang login otomatis di-set di controller --}}
                        @if(Auth::user()->isAdmin())
                            <div class="mb-3">
                                <label for="dinas_id" class="form-label">
                                    Dinas <span class="text-danger">*</span>
                                </label>
                                <select id="dinas_id" name="dinas_id"
                                    class="form-select @error('dinas_id') is-invalid @enderror">
                                    <option value="">-- Pilih Dinas --</option>
                                    @foreach ($dinas as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('dinas_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dinas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            {{-- Dinas yang login: tampilkan info dinas sendiri (read-only) --}}
                            <div class="mb-3">
                                <label class="form-label">Dinas</label>
                                <div class="form-control bg-light text-muted">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="form-text">TPI ini akan otomatis terdaftar di bawah dinas Anda.</div>
                            </div>
                        @endif

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control"
                                required>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('tpi.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
