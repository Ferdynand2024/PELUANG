<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'alamat',
        'latitude',
        'longitude',
        'role',
        'password',
        'status',
        'dinas_id',
        'fingerprint_device',
        'action',
        'session_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Role checks ───────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDinas(): bool
    {
        return $this->role === 'dinas';
    }

    public function isTpi(): bool
    {
        return $this->role === 'tpi';
    }

    public function isActive(): bool
    {
        return $this->status == 1;
    }

    // ── Relasi ────────────────────────────────────────────────────

    // Dinas memiliki banyak TPI
    public function tpiList()
    {
        return $this->hasMany(User::class, 'dinas_id')->where('role', 'tpi');
    }

    // TPI milik satu Dinas
    public function dinas()
    {
        return $this->belongsTo(User::class, 'dinas_id');
    }

    // TPI memiliki banyak produk
    public function produks()
    {
        return $this->hasMany(Produk::class, 'tpi_id');
    }

    // TPI memiliki banyak jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'tpi_id');
    }

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class);
    }
}