<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiterimaNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $produkId,
        public string $jenisIkan,
        public string $pembeliNama,
        public float $jumlahBayar,
    ) {}

    /**
     * FITUR BARU: notifikasi disimpan ke database (tabel notifications),
     * ditampilkan lewat bell icon di navbar TPI.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'produk_id'    => $this->produkId,
            'jenis_ikan'   => $this->jenisIkan,
            'pembeli_nama' => $this->pembeliNama,
            'jumlah_bayar' => $this->jumlahBayar,
            'message'      => "Pembayaran lelang \"{$this->jenisIkan}\" sebesar Rp "
                . number_format($this->jumlahBayar, 0, ',', '.')
                . " telah diterima dari {$this->pembeliNama}.",
        ];
    }
}