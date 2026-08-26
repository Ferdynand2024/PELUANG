<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\User;
use App\Models\Produk;
use App\Notifications\PembayaranDiterimaNotification;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$isProduction = config('midtrans.is_production');
    }

    // Tampilkan halaman pembayaran
    public function showPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        // Ambil pemenang aktif (status = 'belum')
        $pemenang = $produk->penawaran
            ->sortByDesc('jumlah_penawaran')
            ->firstWhere('status', 'belum');

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melakukan pembayaran');
        }

        // Tentukan batas pembayaran sesuai pemenang
        if ($pemenang->id === $produk->penawaran->sortByDesc('jumlah_penawaran')->first()->id) {
            // pemenang1
            $batasWaktuPembayaran = $produk->waktu_selesai->copy()->addMinutes(2);
        } else {
            // pemenang2
            $batasWaktuPembayaran = $produk->waktu_gugur_pemenang1->copy()->addMinutes(2);
        }

        if (now()->greaterThan($batasWaktuPembayaran)) {
            abort(403, 'Batas waktu pembayaran telah habis.');
        }

        $transaction_details = [
            'order_id' => 'lelang-' . $produk->id . '-' . time(),
            'gross_amount' => $pemenang->jumlah_penawaran,
        ];

        $customer_details = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pembeli.pembayaran', compact('produk', 'snapToken'));
    }

    public function chargePembayaran(Request $request, $id)
    {
        // Tangani notifikasi / callback dari Midtrans
        $notif = $request->all();

        // Validasi signature dari Midtrans agar tidak bisa dipalsukan
        $serverKey       = config('midtrans.server_key');
        $orderId         = $notif['order_id'] ?? null;
        $statusCode      = $notif['status_code'] ?? null;
        $grossAmount     = $notif['gross_amount'] ?? null;
        $signatureKey    = $notif['signature_key'] ?? null;

        if ($orderId && $statusCode && $grossAmount && $serverKey) {
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            if ($signatureKey && $signatureKey !== $expectedSignature) {
                return response()->json(['message' => 'Invalid signature.'], 403);
            }
        }

        $transactionStatus = $notif['transaction_status'] ?? null;
        $fraudStatus       = $notif['fraud_status'] ?? null;

        // Tentukan status berdasarkan respon Midtrans
        if ($transactionStatus === 'capture') {
            $status = ($fraudStatus === 'accept') ? 'success' : 'failure';
        } elseif (in_array($transactionStatus, ['settlement', 'pending'])) {
            $status = $transactionStatus;
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $status = 'failure';
        } else {
            $status = $transactionStatus ?? 'unknown';
        }

        // Tandai pemenang sudah bayar jika pembayaran berhasil
        if (in_array($status, ['success', 'settlement'])) {
            // FITUR BARU: eager-load 'tpi' & 'penawaran.user' sekalian, dipakai buat notifikasi di bawah
            $produk   = Produk::with(['penawaran.user', 'tpi'])->findOrFail($id);
            $pemenang = $produk->penawaran
                ->sortByDesc('jumlah_penawaran')
                ->firstWhere('status', 'belum');

            if ($pemenang) {
                $statusSebelumnya = $pemenang->status;

                $pemenang->status = 'sudah';
                $pemenang->save();

                // FITUR BARU: kirim notifikasi ke TPI pemilik produk, hanya kalau status
                // sebelumnya belum 'sudah' (guard biar tidak dobel kalau chargePembayaran
                // dan konfirmasiPembayaran sama-sama sempat jalan untuk transaksi yang sama).
                if ($statusSebelumnya !== 'sudah' && $produk->tpi) {
                    $produk->tpi->notify(new PembayaranDiterimaNotification(
                        produkId: $produk->id,
                        jenisIkan: $produk->jenis_ikan,
                        pembeliNama: $pemenang->user->name ?? 'Pembeli',
                        jumlahBayar: $pemenang->jumlah_penawaran,
                    ));
                }
            }
        }

        return response()->json(['message' => 'OK']);
    }

    public function buktiPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        // Ambil semua penawaran urut terbesar
        $penawarans = $produk->penawaran()->orderByDesc('jumlah_penawaran')->get();

        $pemenang1 = $penawarans->get(0);
        $pemenang2 = $penawarans->get(1);

        // Cari pemenang sah yang sudah bayar
        $pemenang = null;
        if ($pemenang1 && $pemenang1->status === 'sudah') {
            $pemenang = $pemenang1;
        } elseif ($pemenang2 && $pemenang2->status === 'sudah') {
            $pemenang = $pemenang2;
        }

        // Validasi akses
        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat bukti pembayaran');
        }

        $user = $pemenang->user;
        $tpi  = $produk->tpi;  // Ambil TPI pemilik produk ini, bukan TPI pertama yang ditemukan
        $orderId = 'lelang-' . $produk->id . '-' . $pemenang->id;
        $tanggalPembayaran = $pemenang->updated_at ?? $pemenang->created_at;

        return view('pembeli.bukti-pembayaran', compact(
            'produk',
            'pemenang',
            'user',
            'orderId',
            'tanggalPembayaran',
            'tpi'
        ));
    }

    public function downloadBuktiPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        $penawarans = $produk->penawaran()->orderByDesc('jumlah_penawaran')->get();
        $pemenang1 = $penawarans->get(0);
        $pemenang2 = $penawarans->get(1);

        $pemenang = null;
        if ($pemenang1 && $pemenang1->status === 'sudah') {
            $pemenang = $pemenang1;
        } elseif ($pemenang2 && $pemenang2->status === 'sudah') {
            $pemenang = $pemenang2;
        }

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunduh bukti pembayaran ini');
        }

        $user = $pemenang->user;
        $tpi  = $produk->tpi;  // Ambil TPI pemilik produk ini, bukan TPI pertama yang ditemukan
        $orderId = 'lelang-' . $produk->id . '-' . $pemenang->id;
        $tanggalPembayaran = $pemenang->updated_at ?? $pemenang->created_at;

        $data = compact('produk', 'pemenang', 'user', 'tpi', 'orderId', 'tanggalPembayaran');
        $pdf = PDF::loadView('pembeli.bukti-pembayaran-pdf', $data);

        return $pdf->download('bukti-lelang-' . $produk->id . '.pdf');
    }


    public function konfirmasiPembayaran($id)
    {
        // FITUR BARU: eager-load 'penawaran.user' & 'tpi', dipakai buat notifikasi di bawah
        $produk = Produk::with(['penawaran.user', 'tpi'])->findOrFail($id);
        $pemenang = $produk->penawaran->sortByDesc('jumlah_penawaran')->firstWhere('status', 'belum');

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        // Batas pembayaran sesuai pemenang
        if ($pemenang->id === $produk->penawaran->sortByDesc('jumlah_penawaran')->first()->id) {
            $batasWaktuPembayaran = $produk->waktu_selesai->copy()->addMinutes(2);
        } else {
            $batasWaktuPembayaran = $produk->waktu_gugur_pemenang1->copy()->addMinutes(2);
        }

        if (now()->greaterThan($batasWaktuPembayaran)) {
            // Pembeli tidak punya akses ke produk.index (itu route TPI), redirect ke lelang.index
            return redirect()->route('lelang.index')->with('error', 'Waktu pembayaran telah habis.');
        }

        $statusSebelumnya = $pemenang->status;

        $pemenang->status = 'sudah';
        $pemenang->save();

        // FITUR BARU: kirim notifikasi ke TPI pemilik produk, hanya kalau status
        // sebelumnya belum 'sudah' (guard biar tidak dobel kalau webhook Midtrans
        // di chargePembayaran() sudah lebih dulu menandainya 'sudah').
        if ($statusSebelumnya !== 'sudah' && $produk->tpi) {
            $produk->tpi->notify(new PembayaranDiterimaNotification(
                produkId: $produk->id,
                jenisIkan: $produk->jenis_ikan,
                pembeliNama: $pemenang->user->name ?? Auth::user()->name,
                jumlahBayar: $pemenang->jumlah_penawaran,
            ));
        }

        return redirect()->route('lelang.bukti-pembayaran', $produk->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}