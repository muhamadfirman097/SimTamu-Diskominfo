<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
    'nama_tamu',
    'instansi_asal',
    'kontak',
    'divisi_tujuan',
    'keperluan',
    'tanggal_temu',
    'waktu_temu',
    'status',
    'alasan_penolakan', // <-- TAMBAHKAN INI
];
}
