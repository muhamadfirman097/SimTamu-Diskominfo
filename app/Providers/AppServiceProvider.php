<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- 1. Tambahkan ini
use App\Models\Appointment;            // <-- 2. Tambahkan ini

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
        // 3. Tambahkan logika ini
        View::composer('layouts.navigation', function ($view) {
            $pendingAppointmentsCount = Appointment::where('status', 'pending')->count();
            $view->with('pendingAppointmentsCount', $pendingAppointmentsCount);
        });
    }
}
