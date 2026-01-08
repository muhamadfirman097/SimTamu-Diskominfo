<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Untuk error logging

class SendAppointmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment;
    protected $janjiTemuId;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment, string $janjiTemuId)
    {
        $this->appointment = $appointment;
        $this->janjiTemuId = $janjiTemuId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $token = config('services.fonnte.token');
        if (!$token) {
            Log::error('Fonnte token not set. Skipping WA notification.');
            return;
        }

        // 1. Ambil nomor dari field 'kontak'
        $targetNumber = $this->formatPhoneNumber($this->appointment->kontak);

        // 2. Jika setelah diformat nomornya tidak valid, jangan kirim.
        if (empty($targetNumber)) {
             Log::warning('Could not send WA. Invalid or empty phone number after formatting.', ['kontak' => $this->appointment->kontak]);
             return;
        }

        // 3. Siapkan pesan
        $message = sprintf(
            "Pengajuan Janji Temu Berhasil!\n\n" .
            "Terima kasih, *%s*.\n\n" .
            "Pengajuan janji temu Anda telah kami terima dengan detail:\n" .
            "- *ID Janji*: %s\n" .
            "- *Divisi Tujuan*: %s\n" .
            "- *Keperluan*: %s\n\n" .
            "Mohon simpan ID Janji Temu untuk melakukan pengecekan status.\n\n" .
            "Terima kasih,\n*%s*",
            $this->appointment->nama_tamu,
            $this->janjiTemuId,
            $this->appointment->divisi_tujuan,
            $this->appointment->keperluan,
            config('app.name', 'SimTamu Diskominfo') //
        );

        // 4. Kirim ke API Fonnte
        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [ // Ganti URL jika Fonnte Anda beda
                'target' => $targetNumber,
                'message' => $message
            ]);

            if ($response->failed()) {
                Log::error('Fonnte API request failed.', $response->json());
            } else {
                Log::info('Fonnte WA sent successfully.', ['target' => $targetNumber]);
            }
        } catch (\Exception $e) {
            Log::critical('Exception when sending WA via Fonnte.', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Membersihkan dan memformat nomor telepon ke standar 62.
     * Contoh: "0812-345-678" menjadi "62812345678"
     * Contoh: "+62 812 345 678" menjadi "62812345678"
     * Contoh: "nama@gmail.com" menjadi "" (string kosong)
     */
    private function formatPhoneNumber($number)
    {
        // 1. Hapus semua karakter kecuali angka
        $cleaned = preg_replace('/[^\d]/', '', $number);

        // 2. Jika berisi email, preg_replace akan menghapus semuanya
        if (empty($cleaned)) {
            return ''; // Bukan nomor telepon
        }

        // 3. Cek apakah nomor valid (minimal 9 digit)
        if (strlen($cleaned) < 9) {
             return ''; // Nomor tidak valid
        }

        // 4. Ganti '0' di depan dengan '62'
        if (substr($cleaned, 0, 1) === '0') {
            return '62' . substr($cleaned, 1);
        }

        // 5. Jika sudah '62', biarkan
        if (substr($cleaned, 0, 2) === '62') {
            return $cleaned;
        }

        // 6. Jika kasus lain (misal: 812...), tambahkan 62
        return '62' . $cleaned;
    }
}
