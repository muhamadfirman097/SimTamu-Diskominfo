<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; // Import View Facade
use App\Models\Appointment;          // Import Model Appointment
use Carbon\Carbon;                   // Import Carbon untuk pengaturan tanggal

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // =========================================================
        // 1. PENGATURAN BAHASA (LOCALE) INDONESIA
        // =========================================================
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // =========================================================
        // 2. KEAMANAN & HTTPS (PRODUCTION)
        // =========================================================
        // Paksa HTTPS saat di production/Vercel agar CSS termuat aman
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // =========================================================
        // 3. INJEKSI DATA KE VIEW (SIDEBAR NAVIGATION)
        // =========================================================
        // Kirim data notifikasi ke Menu Navigasi (Side Bar)
        // Ini mencegah error "Undefined variable $pendingAppointmentsCount"
        View::composer('layouts.navigation', function ($view) {
            $count = 0;
            
            try {
                // Cek database untuk menghitung janji temu status 'pending'
                // Menggunakan try-catch agar aman jika tabel belum dimigrasi
                if (class_exists(Appointment::class)) {
                    $count = Appointment::where('status', 'pending')->count();
                }
            } catch (\Exception $e) {
                // Jika terjadi error database (misal saat proses deploy awal), anggap 0
                $count = 0;
            }
            
            // Kirim variabel ke view
            $view->with('pendingAppointmentsCount', $count);
        });
    }
}
