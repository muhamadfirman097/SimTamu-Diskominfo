<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->string('nama_tamu');
        $table->string('instansi_asal');
        $table->string('kontak');
        $table->string('divisi_tujuan'); // Contoh: Bidang E-Gov, Bidang IKP, Sekretariat
        $table->text('keperluan');
        $table->date('tanggal_temu');
        $table->time('waktu_temu');
        $table->string('status')->default('pending'); // pending, disetujui, ditolak, selesai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
