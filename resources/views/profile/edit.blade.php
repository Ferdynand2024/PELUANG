@extends('layouts.navigasi')

@section('title', 'Halaman Profil — PELUANG')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan keamanan Anda')

@push('styles')
<style>
    .profile-wrap {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        max-width: 640px;
        margin: 0 auto;   
        width: 100%;  
    }

    .profile-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }

    .profile-section header {
        margin-bottom: 1.5rem;
    }
    .profile-section header h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
        margin-bottom: .35rem;
    }
    .profile-section header p {
        font-size: .82rem;
        color: #64748b;
        line-height: 1.5;
    }
    .profile-section.danger header h2 { color: #991b1b; }

    .form-group {
        margin-bottom: 1.1rem;
    }
    .form-group label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: .4rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
        width: 100%;
        padding: .65rem .85rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: .875rem;
        font-family: inherit;
        color: #1e293b;
        background: #f8fafc;
        transition: border-color .15s, box-shadow .15s;
        outline: none;
    }
    .form-group input:focus {
        border-color: #0f1f3d;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(15,31,61,.08);
    }
    .form-error {
        margin-top: .4rem;
        font-size: .78rem;
        color: #ef4444;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .65rem 1.4rem;
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
    .btn-primary:hover { background: #162847; }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .65rem 1.4rem;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-danger:hover { background: #fecaca; }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        padding: .65rem 1.2rem;
        background: #fff;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: border-color .15s, color .15s;
    }
    .btn-secondary:hover { border-color: #94a3b8; color: #1e293b; }

    .saved-msg {
        font-size: .82rem;
        color: #16a34a;
        font-weight: 600;
    }

    .verify-notice {
        margin-top: .5rem;
        padding: .75rem 1rem;
        background: #fff7e6;
        border: 1px solid rgba(240,165,0,.35);
        border-radius: 8px;
    }
    .verify-notice p {
        font-size: .8rem;
        color: #92620a;
        line-height: 1.5;
    }
    .verify-notice button {
        background: none;
        border: none;
        font-family: inherit;
        font-size: .8rem;
        font-weight: 700;
        color: #c4870a;
        text-decoration: underline;
        cursor: pointer;
        padding: 0;
    }
    .verify-sent {
        margin-top: .5rem;
        font-size: .8rem;
        color: #16a34a;
        font-weight: 600;
    }

    /* ── Delete modal ───────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15,31,61,.6);
        backdrop-filter: blur(2px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 12px;
        padding: 1.75rem;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 12px 40px rgba(0,0,0,.2);
    }
    .modal-box h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1f3d;
        margin-bottom: .5rem;
    }
    .modal-box p {
        font-size: .82rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: .6rem;
        margin-top: 1.25rem;
    }
</style>
@endpush

@section('content')

<div class="profile-wrap">

    {{-- ── Profile Information ─────────────────────── --}}
    <div class="profile-section">
        <header>
            <h2>Informasi Profil</h2>
            <p>Perbarui nama dan alamat email akun Anda.</p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <p class="form-error">{{ $message }}</p> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="verify-notice">
                        <p>
                            Alamat email Anda belum diverifikasi.
                            <button form="send-verification" type="submit">Kirim ulang email verifikasi.</button>
                        </p>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="verify-sent">Tautan verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
                @if (session('status') === 'profile-updated')
                    <span class="saved-msg">Tersimpan.</span>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Update Password ─────────────────────────── --}}
    <div class="profile-section">
        <header>
            <h2>Ubah Kata Sandi</h2>
            <p>Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
        </header>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="update_password_current_password">Kata Sandi Saat Ini</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                @error('current_password', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="update_password_password">Kata Sandi Baru</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                @error('password', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="update_password_password_confirmation">Konfirmasi Kata Sandi</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
                @if (session('status') === 'password-updated')
                    <span class="saved-msg">Tersimpan.</span>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Delete Account ──────────────────────────── --}}
    <div class="profile-section danger">
        <header>
            <h2>Hapus Akun</h2>
            <p>Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi apa pun yang ingin Anda simpan.</p>
        </header>

        <button type="button" class="btn-danger" onclick="openDeleteModal()">Hapus Akun</button>
    </div>

</div>

{{-- ── Delete confirmation modal ───────────────────── --}}
<div class="modal-overlay {{ $errors->userDeletion->isNotEmpty() ? 'open' : '' }}" id="deleteModalOverlay">
    <div class="modal-box">
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <h3>Apakah Anda yakin ingin menghapus akun Anda?</h3>
            <p>Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.</p>

            <div class="form-group">
                <label for="password" class="sr-only" style="position:absolute;width:1px;height:1px;overflow:hidden;">Kata Sandi</label>
                <input id="password" name="password" type="password" placeholder="Kata Sandi" style="width:75%;">
                @error('password', 'userDeletion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="btn-danger">Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openDeleteModal() {
        document.getElementById('deleteModalOverlay').classList.add('open');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModalOverlay').classList.remove('open');
    }
    document.getElementById('deleteModalOverlay')?.addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endpush