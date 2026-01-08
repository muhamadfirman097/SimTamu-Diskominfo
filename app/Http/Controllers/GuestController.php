<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Events\AppointmentSubmitted;
use App\Models\Division;
use App\Jobs\SendAppointmentNotification; // <-- 1. TAMBAHKAN IMPORT JOB INI

class GuestController extends Controller
{
    /**
     * Menampilkan formulir untuk membuat janji temu.
     *
     * @return \Illuminate\View\View
     */
    public function createAppointmentForm()
    {
        // 2. Ambil semua data divisi dari database
        $divisions = Division::orderBy('name')->get();

        // 3. Kirim data tersebut ke view
        return view('appointment_form', compact('divisions'));
    }

    /**
     * Menyimpan data janji temu yang baru diajukan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function storeAppointment(Request $request)
{
    // ... (kode validasi Anda) ...
    $request->validate([
        'nama_tamu'     => 'required|string|max:255',
        'instansi_asal' => 'required|string|max:255',
        'kontak'        => 'required|string|max:100',
        'divisi_tujuan' => 'required|string',
        'new_division_name' => 'required_if:divisi_tujuan,other|nullable|string|max:255|unique:divisions,name',
        'keperluan'     => 'required|string',
        'tanggal_temu'  => 'required|date',
        'waktu_temu'    => 'required',
    ]);

    if ($request->divisi_tujuan === 'other') {
        $newDivision = Division::create(['name' => $request->new_division_name]);
        $request->merge(['divisi_tujuan' => $newDivision->name]);
    }

    $appointment = Appointment::create($request->all());

    // =======================================================
    // ==== ❗ KODE YANG HILANG ADA DI SINI, TAMBAHKAN KEMBALI ====
    // =======================================================
    $namaInisial = strtoupper(substr($appointment->nama_tamu, 0, 2));
    $janjiTemuId = 'JT' . str_pad($appointment->id, 2, '0', STR_PAD_LEFT) . '-' . $namaInisial;

    // <-- 2. TAMBAHKAN BARIS INI
    // Mengirim tugas pengiriman WA ke antrian (queue)
    // Job ini akan berjalan di latar belakang
    SendAppointmentNotification::dispatch($appointment, $janjiTemuId);

    broadcast(new AppointmentSubmitted());

    // Sekarang, variabel $janjiTemuId sudah ada dan bisa digunakan
    return redirect()->route('appointment.success')->with('janjiTemuId', $janjiTemuId);
}

    public function showStatusCheckForm()
    {
        return view('status_check_form');
    }

    /**
     * Memproses ID Janji Temu dan menampilkan hasilnya.
     */
    public function checkStatus(Request $request)
    {
        // Validasi input
        $request->validate(['id_janji_temu' => 'required|string']);

        $idJanjiTemu = $request->id_janji_temu;
        $appointment = null;

        // Ekstrak ID numerik dari string (contoh: JT01-MU -> 1)
        if (preg_match('/^(JT)(\d+)/i', $idJanjiTemu, $matches)) {
            $appointmentId = (int)$matches[2];
            $appointment = Appointment::find($appointmentId);
        }

        // Kirim hasil pencarian ke view
        return view('status_result', compact('appointment', 'idJanjiTemu'));
    }
}
