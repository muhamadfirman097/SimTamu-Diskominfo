<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        // 1. Ambil Token: Cek config dulu, kalau kosong ambil langsung dari ENV
        // Ini memastikan token 'w8AmWYeCe8W5UcXqiCLY' yang Anda set di Vercel terbaca
        $token = config('services.fonnte.token') ?? env('FONNTE_TOKEN');

        if (empty($token)) {
            Log::error('[WA Job] GAGAL: Fonnte Token belum di-set di Vercel (FONNTE_TOKEN).');
            return;
        }

        // 2. Format Nomor HP
        $targetNumber = $this->formatPhoneNumber($this->appointment->kontak);
        if (empty($targetNumber)) {
             Log::warning('[WA Job] GAGAL: Nomor HP tidak valid.', ['kontak' => $this->appointment->kontak]);
             return;
        }

        // 3. Siapkan Pesan
        $appName = config('app.name', 'SimTamu Diskominfo');
        $message = sprintf(
            "Halo, *%s* 👋\n\n" .
            "Pengajuan Janji Temu Anda *BERHASIL* diterima sistem.\n\n" .
            "📋 *Detail Tiket:*\n" .
            "🆔 ID Tiket: *%s* (Simpan ini!)\n" .
            "🏢 Tujuan: %s\n" .
            "📝 Keperluan: %s\n\n" .
            "Silakan gunakan ID Tiket untuk cek status persetujuan di website kami.\n\n" .
            "Salam,\n*%s*",
            $this->appointment->nama_tamu,
            $this->janjiTemuId,
            $this->appointment->divisi_tujuan,
            $this->appointment->keperluan,
            $appName
        );

        // 4. Kirim ke API Fonnte
        try {
            Log::info('[WA Job] Mengirim ke Fonnte...', ['target' => $targetNumber]);

            $response = Http::timeout(10)->withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $targetNumber,
                'message' => $message,
                'countryCode' => '62', 
            ]);

            if ($response->successful()) {
                Log::info('[WA Job] SUKSES: Notifikasi terkirim.', ['response' => $response->json()]);
            } else {
                Log::error('[WA Job] GAGAL: Fonnte menolak.', ['status' => $response->status(), 'body' => $response->body()]);
            }

        } catch (\Exception $e) {
            Log::critical('[WA Job] ERROR SYSTEM: Gagal menghubungi Fonnte.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Format nomor ke 62
     */
    private function formatPhoneNumber($number)
    {
        $cleaned = preg_replace('/[^\d]/', '', $number);
        if (empty($cleaned) || strlen($cleaned) < 9) return '';
        
        if (substr($cleaned, 0, 1) === '0') return '62' . substr($cleaned, 1);
        if (substr($cleaned, 0, 2) === '62') return $cleaned;
        
        return '62' . $cleaned;
    }
}