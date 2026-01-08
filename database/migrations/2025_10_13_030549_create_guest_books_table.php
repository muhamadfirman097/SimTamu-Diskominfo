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
    Schema::create('guest_books', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('appointment_id')->nullable(); // Relasi jika dari janji temu
        $table->string('nama_tamu');
        $table->string('instansi_asal');
        $table->string('divisi_tujuan');
        $table->text('keperluan');
        $table->dateTime('waktu_masuk');
        $table->dateTime('waktu_keluar')->nullable();
        $table->string('tipe_kunjungan'); // janji_temu atau on_the_spot
        $table->timestamps();

        $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
