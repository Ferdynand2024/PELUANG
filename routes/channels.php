<?php
// routes/channels.php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('produk.{produkId}', function ($user, $produkId) {
    // Semua role yang sudah login boleh subscribe ke channel produk manapun
    // (data lelang memang publik untuk user login — admin/dinas/tpi/pembeli)
    return in_array($user->role, ['admin', 'dinas', 'tpi', 'pembeli']);
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});