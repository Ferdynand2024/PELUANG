<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TpiController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanLelangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FingerprintController;
use App\Http\Controllers\RealtimeMonitoringController;
use App\Http\Controllers\DinasController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NotifikasiController;

// ── Public routes ─────────────────────────────────────────────────

Route::get('/', [ProdukController::class, 'landing'])->name('landingpage');

Route::get('/about', fn() => view('about'))->name('about');
Route::get('/faq',   fn() => view('faq'))->name('faq');

Route::get('/tpi/cari-terdekat', [TpiController::class, 'cariTerdekat'])->name('tpi.cari-terdekat');
Route::get('/api/tpi/terdekat',  [TpiController::class, 'getTerdekatJson'])->name('tpi.terdekat-json');

// FIX: route lama manggil LelangController yang nggak ada/nggak di-import
// (bikin route file error saat di-load). Diganti ke ProdukController yang
// beneran punya method produkAktifByTpiJson untuk fitur "Lihat Lelang".
Route::get('/tpi/{tpiId}/produk-aktif-json', [ProdukController::class, 'produkAktifByTpiJson'])
    ->name('tpi.produk-aktif-json');

Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/test-email', function () {
    Mail::raw('Test email dari Laravel.', function ($msg) {
        $msg->to('alamat@email.com')->subject('Tes Email');
    });
    return 'Email dikirim!';
});

// ── Dashboard ─────────────────────────────────────────────────────

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ── Fingerprint (sebelum login, tanpa auth) ───────────────────────

Route::post('/cek-fingerprint', [FingerprintController::class, 'check'])
    ->name('cek.fingerprint');

// ── Semua role yang sudah login ───────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':admin,dinas,tpi,pembeli'])->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pembeli bisa menawar (diakses dari semua role tapi logic di controller)
    Route::post('/produk/{id}/penawaran', [PenawaranController::class, 'store'])
        ->name('penawaran.store');
});

// ── Admin saja ────────────────────────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    // Manajemen Dinas (hanya admin yang bisa buat akun dinas)
    Route::get('/dinas',                       [DinasController::class, 'index'])->name('dinas.index');
    Route::get('/dinas/create',                [DinasController::class, 'create'])->name('dinas.create');
    Route::post('/dinas',                      [DinasController::class, 'store'])->name('dinas.store');
    Route::get('/dinas/{dinas}/edit',          [DinasController::class, 'edit'])->name('dinas.edit');
    Route::put('/dinas/{dinas}',               [DinasController::class, 'update'])->name('dinas.update');
    Route::patch('/dinas/{dinas}/toggle-status', [DinasController::class, 'toggleStatus'])
        ->name('dinas.toggle-status');

    // Manajemen Pembeli
    Route::get('/pembeli', [PembeliController::class, 'index'])->name('pembeli.index');
});

// ── Admin + Dinas: kelola TPI ─────────────────────────────────────
// Admin bisa kelola semua TPI, Dinas hanya bisa kelola TPI miliknya

Route::middleware(['auth', CheckRole::class . ':admin,dinas'])->group(function () {
    // Daftar TPI
    // (admin lihat semua, dinas lihat miliknya — difilter di controller)
    Route::get('/tpi',                       [DinasController::class, 'tpiIndex'])->name('tpi.index');
    Route::get('/tpi/create',                [DinasController::class, 'tpiCreate'])->name('tpi.create');
    Route::post('/tpi',                      [DinasController::class, 'tpiStore'])->name('tpi.store');
    Route::get('/tpi/{tpi}/edit',            [DinasController::class, 'tpiEdit'])->name('tpi.edit');
    Route::put('/tpi/{tpi}',                 [DinasController::class, 'tpiUpdate'])->name('tpi.update');
    Route::patch('/tpi/{tpi}/toggle-status', [DinasController::class, 'tpiToggleStatus'])
        ->name('tpi.toggle-status');
});

// ── Admin + Dinas + TPI: laporan ──────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':admin,dinas,tpi'])->group(function () {
    Route::get('/laporan-lelang', [LaporanLelangController::class, 'index'])->name('laporan.lelang');
    Route::get('/laporan/export', [LaporanLelangController::class, 'export'])->name('laporan.export');

    Route::get('/laporan', [LaporanLelangController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanLelangController::class, 'export'])->name('laporan.export');

    // FITUR 1: Laporan khusus TPI yang sedang login
    Route::get('/laporan/tpi', [LaporanLelangController::class, 'tpiIndex'])->name('laporan.tpi.index');
    Route::get('/laporan/tpi/export', [LaporanLelangController::class, 'tpiExport'])->name('laporan.tpi.export');

    // FITUR 2: Laporan Dinas — lintas TPI miliknya
    Route::get('/laporan/dinas', [LaporanLelangController::class, 'dinasIndex'])->name('laporan.dinas.index');
    Route::get('/laporan/dinas/export', [LaporanLelangController::class, 'dinasExport'])->name('laporan.dinas.export');
});

// ── TPI saja: produk & lelang ─────────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':tpi'])->group(function () {
    // CRUD produk (index, create, store, edit, update, destroy)
    // 'show' dikecualikan karena dipakai ulang untuk pembeli
    Route::resource('produk', ProdukController::class)->except(['show']);

    Route::get('/notifikasi/json', [NotifikasiController::class, 'json'])->name('notifikasi.json');
    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.baca');

    // Mulai & selesaikan lelang
    Route::post('/lelang/{produk}/mulai',   [ProdukController::class, 'mulai'])->name('lelang.mulai');
    Route::put('/lelang/{produk}/selesai',  [ProdukController::class, 'selesaiLelang'])->name('lelang.selesai');

    // Daftar penawaran per produk
    Route::get('/produk/{produk}/penawaran', [ProdukController::class, 'showPenawaran'])
        ->name('produk.penawaran');

    // Notifikasi WA ke pemenang cadangan
    Route::post('/produk/{id}/kirim-notif-cadangan', [ProdukController::class, 'kirimNotifCadangan'])
        ->name('produk.kirimNotifCadangan');

    // Tutup lelang otomatis (dipanggil cron job atau manual)
    Route::get('/lelang/tutup-otomatis', [ProdukController::class, 'tutupLelangOtomatis'])
        ->name('lelang.tutup-otomatis');
});

// ── TPI + Pembeli: jadwal ─────────────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':tpi,pembeli'])->group(function () {
    Route::resource('jadwal', JadwalController::class);
    Route::get('/jadwallelang', [JadwalController::class, 'index1'])->name('jadwallelang');
});

// ── Pembeli saja ──────────────────────────────────────────────────

Route::middleware(['auth', CheckRole::class . ':pembeli'])->group(function () {
    // Daftar & detail produk lelang aktif
    Route::get('/lelang',      [ProdukController::class, 'index2'])->name('lelang.index');
    Route::get('/lelang/{id}', [ProdukController::class, 'show'])->name('lelang.show');

    // Pembayaran
    Route::get('/lelang/{id}/pembayaran',          [PembayaranController::class, 'showPembayaran'])
        ->name('lelang.pembayaran');
    Route::post('/lelang/{id}/pembayaran/charge',  [PembayaranController::class, 'chargePembayaran'])
        ->name('lelang.pembayaran.charge');
    Route::get('/lelang/{id}/bukti-pembayaran',    [PembayaranController::class, 'buktiPembayaran'])
        ->name('lelang.bukti-pembayaran');
    Route::get('/bukti-pembayaran/{id}/download',  [PembayaranController::class, 'downloadBuktiPembayaran'])
        ->name('bukti-pembayaran.download');
    Route::get('/pembayaran/konfirmasi/{id}',       [PembayaranController::class, 'konfirmasiPembayaran'])
        ->name('pembayaran.konfirmasi');
});

// ── SSE Realtime (semua role yang login) ──────────────────────────

Route::middleware(['auth'])->group(function () {
    // Ganti nama prefix agar tidak mirip API
    Route::get('/realtime/stream', [RealtimeMonitoringController::class, 'stream'])
        ->name('realtime.attendance-stream')
        ->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class]);
});

require __DIR__ . '/auth.php';