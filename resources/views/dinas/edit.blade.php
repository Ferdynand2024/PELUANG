@extends('layouts.navigasi')

@section('title', 'Edit Dinas')
@section('page-title', 'Edit Dinas')
@section('page-subtitle', 'Perbarui data dinas yang terdaftar')
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

                    <form method="POST" action="{{ route('dinas.update', $dinas->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Dinas <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $dinas->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
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
                                value="{{ old('email', $dinas->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $dinas->phone) }}"
                                class="form-control">
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="form-control">{{ old('alamat', $dinas->alamat) }}</textarea>
                        </div>

                        {{-- Password (opsional saat edit) --}}
                        <div class="mb-1">
                            <label class="form-label">
                                Password Baru
                                <span class="text-muted small fw-normal">(kosongkan jika tidak diubah)</span>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control">
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Perbarui
                            </button>
                            <a href="{{ route('dinas.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
