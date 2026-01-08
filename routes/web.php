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

// Halaman utama untuk mengajukan janji temu
Route::get('/', [GuestController::class, 'createAppointmentForm'])->name('appointment.create');

// Proses pengiriman form janji temu
Route::post('/appointment', [GuestController::class, 'storeAppointment'])->name('appointment.store');

// Halaman sukses setelah mengajukan janji temu
Route::get('/success', function () {
    return view('success');
})->name('appointment.success');

// Halaman untuk menampilkan form cek status
Route::get('/cek-status', [GuestController::class, 'showStatusCheckForm'])->name('status.check.form');

// Halaman untuk memproses dan menampilkan hasil cek status
Route::post('/cek-status', [GuestController::class, 'checkStatus'])->name('status.check');


// --- RUTE UNTUK ADMIN (MEMERLUKAN LOGIN) ---

// Grup rute yang hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/divisions', [SettingsController::class, 'storeDivision'])->name('admin.divisions.store');
    Route::patch('/admin/divisions/{division}', [SettingsController::class, 'updateDivision'])->name('admin.divisions.update');
    Route::delete('/admin/divisions/{division}', [SettingsController::class, 'destroyDivision'])->name('admin.divisions.destroy');

    // Kelola Janji Temu
    Route::get('/admin/appointments', [AdminController::class, 'listAppointments'])->name('admin.appointments');
    Route::post('/admin/appointments/{id}/approve', [AdminController::class, 'approveAppointment'])->name('admin.appointments.approve');
    Route::post('/admin/appointments/{id}/reject', [AdminController::class, 'rejectAppointment'])->name('admin.appointments.reject');

    // Kelola Buku Tamu
    Route::get('/admin/guest-book', [AdminController::class, 'listGuestBook'])->name('admin.guestbook');
    Route::get('/admin/guest-book/create', [AdminController::class, 'createGuestForm'])->name('admin.guestbook.create');
    Route::post('/admin/guest-book', [AdminController::class, 'storeGuest'])->name('admin.guestbook.store');

    // Rute untuk Ekspor Excel
    Route::get('/admin/guest-book/export', [AdminController::class, 'exportGuestBook'])->name('admin.guestbook.export');

    Route::get('/admin/guest-book/delete', [AdminController::class, 'showDeleteGuestBookForm'])->name('admin.guestbook.show_delete_form');
    Route::delete('/admin/guest-book', [AdminController::class, 'bulkDestroyGuestBook'])->name('admin.guestbook.bulk_destroy');
});


// --- RUTE OTENTIKASI BAWAAN LARAVEL BREEZE ---

// Rute ini menangani semua proses login, logout, register, dll.
require __DIR__.'/auth.php';
