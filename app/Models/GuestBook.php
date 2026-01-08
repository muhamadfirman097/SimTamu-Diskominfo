<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_id', // <-- TAMBAHKAN BARIS INI
        'nama_tamu',
        'instansi_asal',
        'divisi_tujuan',
        'keperluan',
        'waktu_masuk',
        'waktu_keluar',
        'tipe_kunjungan',
    ];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
