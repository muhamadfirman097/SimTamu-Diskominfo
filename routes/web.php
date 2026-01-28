<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- RUTE UNTUK TAMU UMUM (PUBLIK) ---

// Halaman utama (Form Tamu)
Route::get('/', [GuestController::class, 'createAppointmentForm'])->name('home');
Route::get('/appointment', [GuestController::class, 'createAppointmentForm'])->name('appointment.create');

// Proses pengiriman form janji temu
Route::post('/appointment', [GuestController::class, 'store'])->name('appointment.store');

// Halaman sukses
Route::view('/success', 'success')->name('appointment.success');

// Halaman Cek Status
Route::get('/status-check', [GuestController::class, 'showStatusCheckForm'])->name('status.check.form');
Route::post('/status-check', [GuestController::class, 'checkStatus'])->name('status.check');

// Alias untuk '/cek-status'
Route::get('/cek-status', [GuestController::class, 'showStatusCheckForm']);
Route::post('/cek-status', [GuestController::class, 'checkStatus']);


// --- RUTE UNTUK ADMIN (MEMERLUKAN LOGIN) ---

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Admin
    // PERBAIKAN: Mengarah ke folder resources/views/admin/dashboard.blade.php
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Settings & Divisions
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/divisions', [SettingsController::class, 'storeDivision'])->name('admin.divisions.store');
    Route::patch('/admin/divisions/{division}', [SettingsController::class, 'updateDivision'])->name('admin.divisions.update');
    Route::delete('/admin/divisions/{division}', [SettingsController::class, 'destroyDivision'])->name('admin.divisions.destroy');

    // Kelola Janji Temu (Appointments)
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::post('/admin/appointments/{id}/approve', [AdminController::class, 'approveAppointment'])->name('admin.appointments.approve');
    Route::post('/admin/appointments/{id}/reject', [AdminController::class, 'rejectAppointment'])->name('admin.appointments.reject');

    // Kelola Buku Tamu (Guest Book)
    Route::get('/admin/guest-book', [AdminController::class, 'index'])->name('admin.guestbook');
    Route::get('/admin/guest-book/create', [AdminController::class, 'create'])->name('admin.guestbook.create');
    Route::post('/admin/guest-book', [AdminController::class, 'store'])->name('admin.guestbook.store');
    
    // Rute Delete Guestbook
    Route::get('/admin/guest-book/delete', [AdminController::class, 'showDeleteGuestBookForm'])->name('admin.guestbook.show_delete_form');
    Route::delete('/admin/guest-book', [AdminController::class, 'bulkDestroyGuestBook'])->name('admin.guestbook.bulk_destroy');

    // Rute Ekspor Excel
    Route::get('/admin/guest-book/export', [AdminController::class, 'exportGuestBook'])->name('admin.guestbook.export');
});

// --- RUTE OTENTIKASI BAWAAN LARAVEL BREEZE ---
require __DIR__.'/auth.php';