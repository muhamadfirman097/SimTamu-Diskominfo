<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN BARIS INI

class Division extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'kontak'];
}
