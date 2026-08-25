<?php

namespace App\Events;

use App\Models\Penawaran;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PenawaranDibuat implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public Penawaran $penawaran)
    {
        // load relasi user agar tidak lazy-load saat broadcast
        $this->penawaran->load('user');
    }

    /**
     * Channel publik per produk — semua yang membuka halaman
     * lelang produk ini akan menerima update.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('produk.' . $this->penawaran->produk_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'penawaran.baru';
    }

    /**
     * Data yang dikirim ke frontend — jangan kirim seluruh model
     * mentah kalau tidak perlu.
     */
    public function broadcastWith(): array
    {
        return [
            'id'                => $this->penawaran->id,
            'jumlah_penawaran'  => $this->penawaran->jumlah_penawaran,
            'jumlah_format'     => 'Rp ' . number_format($this->penawaran->jumlah_penawaran, 0, ',', '.'),
            'user_id'           => $this->penawaran->user_id,
            'user_name'         => $this->penawaran->user->name,
            'created_at'        => $this->penawaran->created_at->diffForHumans(),
            'created_at_iso'    => $this->penawaran->created_at->toIso8601String(),
        ];
    }
}