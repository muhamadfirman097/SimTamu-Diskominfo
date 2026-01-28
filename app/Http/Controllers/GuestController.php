<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Events\AppointmentSubmitted;
use App\Models\Division;
use App\Jobs\SendAppointmentNotification; // Import Job Notifikasi

class GuestController extends Controller
{
    /**
     * Menampilkan formulir untuk membuat janji temu.
     *
     * @return \Illuminate\View\View
     */
    public function createAppointmentForm()
    {
        // Ambil semua data divisi dari database
        $divisions = Division::orderBy('name')->get();

        // Kirim data tersebut ke view
        return view('appointment_form', compact('divisions'));
    }

    /**
     * Menyimpan data janji temu yang baru diajukan.
     * * PENTING: Nama fungsi ini harus 'store' karena di routes/web.php 
     * tertulis [GuestController::class, 'store']
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) 
    {
        // Validasi input
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

        // Handle opsi divisi "Lainnya"
        if ($request->divisi_tujuan === 'other') {
            $newDivision = Division::create(['name' => $request->new_division_name]);
            $request->merge(['divisi_tujuan' => $newDivision->name]);
        }

        // Simpan ke database
        $appointment = Appointment::create($request->all());

        // Generate ID Unik (Contoh: JT05-BU) untuk keperluan tampilan & notifikasi
        $namaInisial = strtoupper(substr($appointment->nama_tamu, 0, 2));
        $janjiTemuId = 'JT' . str_pad($appointment->id, 2, '0', STR_PAD_LEFT) . '-' . $namaInisial;

        // Kirim Notifikasi WA (Background Job)
        // Pastikan Worker jalan atau di Vercel pakai cron/langsung
        try {
            SendAppointmentNotification::dispatch($appointment, $janjiTemuId);
        } catch (\Exception $e) {
            // Abaikan error notifikasi agar user tetap bisa submit
            // Log error jika perlu: \Log::error($e->getMessage());
        }

        // Trigger Event Realtime (Pusher)
        try {
            broadcast(new AppointmentSubmitted());
        } catch (\Exception $e) {
            // Abaikan error broadcast
        }

        // Redirect ke halaman sukses dengan membawa ID Tiket
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