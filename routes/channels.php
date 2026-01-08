<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// =======================================================
// ==== ❗ TAMBAHKAN KODE INI UNTUK MEMBERI IZIN ADMIN ====
// =======================================================
Broadcast::channel('admin-notifications', function ($user) {
    // Logika sederhana: Jika pengguna sudah login, beri izin.
    // Anda bisa menambahkan logika lebih kompleks di sini jika perlu (misal: cek role admin)
    return $user != null;
});
