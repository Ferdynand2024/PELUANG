<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'tpi_id',
        'foto',
        'jenis_ikan',
        'berat',
        'harga_awal',
        'deskripsi',
        'status_lelang',
        'waktu_mulai',
        'waktu_selesai',
        'waktu_gugur_pemenang1',
        'pemenang_lelang_id',
        'pemenang_cadangan_id',
        'harga_akhir',
    ];

    protected $casts = [
        'waktu_mulai'           => 'datetime',
        'waktu_selesai'         => 'datetime',
        'waktu_gugur_pemenang1' => 'datetime',
    ];

    // TPI pemilik produk ini
    
    public function tpi()
    {
        return $this->belongsTo(User::class, 'tpi_id');
    }

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class);
    }

    public function pemenangLelang()
    {
        return $this->belongsTo(User::class, 'pemenang_lelang_id');
    }

    public function pemenangCadangan()
    {
        return $this->belongsTo(User::class, 'pemenang_cadangan_id');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'produk_id');
    }
    
    
}