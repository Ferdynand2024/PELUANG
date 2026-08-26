<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * JSON daftar notifikasi TPI yang login. Tidak lagi dipakai oleh
     * halaman produk (yang sekarang render langsung via Blade), tapi
     * dibiarkan tersedia kalau nanti dibutuhkan lagi (mis. widget lain).
     */
    public function json(Request $request)
    {
        $user = Auth::user();

        $notifikasi = $user->notifications()
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'message'    => $n->data['message'] ?? '',
                    'produk_id'  => $n->data['produk_id'] ?? null,
                    'is_read'    => ! is_null($n->read_at),
                    'waktu'      => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'status'       => 'success',
            'unread_count' => $user->unreadNotifications()->count(),
            'data'         => $notifikasi,
        ]);
    }

    /**
     * FITUR BARU: tandai satu notifikasi pembayaran sudah dibaca.
     * Dipanggil dari tombol dismiss (×) di alert halaman Daftar Produk,
     * yang berupa form POST biasa — jadi redirect balik, bukan JSON.
     */
    public function markAsRead(Request $request, string $id)
    {
        $notif = Auth::user()->notifications()->where('id', $id)->first();

        if ($notif && is_null($notif->read_at)) {
            $notif->markAsRead();
        }

        return redirect()->back();
    }
}