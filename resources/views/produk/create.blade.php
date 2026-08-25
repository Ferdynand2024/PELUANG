@extends('layouts.navigasi')

@section('title', 'Tambah Produk — PELUANG')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'Masukkan data produk ikan yang akan dilelang')

@push('styles')
<style>
    .form-wrap {
        display: flex;
        justify-content: center;
    }
    .form-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
        width: 100%;
        max-width: 640px;
    }
    .form-group { margin-bottom: 1.25rem; }
    .form-group:last-of-type { margin-bottom: 0; }
    .form-label {
        display: block;
        font-size: .82rem;
        font-weight: 700;
        color: #0f1f3d;
        margin-bottom: .4rem;
    }
    .form-control {
        width: 100%;
        padding: .6rem .85rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: .85rem;
        font-family: inherit;
        color: #1e293b;
        background: #fff;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus {
        outline: none;
        border-color: #0f1f3d;
        box-shadow: 0 0 0 3px rgba(15,31,61,.08);
    }
    textarea.form-control { resize: vertical; min-height: 110px; }

    .current-photo-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: .6rem;
    }
    .current-photo-row img {
        height: 64px;
        width: 64px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .no-foto-inline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 64px;
        width: 64px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: .68rem;
        font-weight: 600;
    }

    .field-error {
        color: #ef4444;
        font-size: .75rem;
        margin-top: .35rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid #f1f5f9;
    }
    .btn-batal {
        display: inline-flex;
        align-items: center;
        padding: .6rem 1.1rem;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-batal:hover { background: #e2e8f0; color: #475569; }
    .btn-simpan {
        display: inline-flex;
        align-items: center;
        padding: .6rem 1.3rem;
        background: #0f1f3d;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-simpan:hover { background: #162847; color: #fff; }

    @media (max-width: 480px) {
        .form-panel { padding: 1.25rem; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn-batal,
        .form-actions .btn-simpan { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

<div class="form-wrap">
    <div class="form-panel">
        <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
                @error('foto')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_ikan" class="form-label">Jenis Ikan</label>
                <input type="text" name="jenis_ikan" id="jenis_ikan" value="{{ old('jenis_ikan') }}" required class="form-control">
                @error('jenis_ikan')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="berat" class="form-label">Berat (kg)</label>
                <input type="number" name="berat" id="berat" value="{{ old('berat') }}" required class="form-control" min="0" step="0.01">
                @error('berat')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga_awal" class="form-label">Harga Awal (Rp)</label>
                <input type="number" name="harga_awal" id="harga_awal" value="{{ old('harga_awal') }}" required class="form-control" min="0" step="0.01">
                @error('harga_awal')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" required class="form-control">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('produk.index') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

@endsection