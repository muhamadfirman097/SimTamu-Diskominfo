<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\GuestBook;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\GuestBookExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Displays the admin dashboard with statistics.
     */
    public function dashboard()
    {
        // --- Statistics Data ---
        $pendingAppointmentsCount = Appointment::where('status', 'pending')->count();
        $todayGuestCount = GuestBook::whereDate('waktu_masuk', Carbon::today())->count();
        
        // Kunjungan bulan ini
        $monthlyGuestCount = GuestBook::whereMonth('waktu_masuk', Carbon::now()->month)
                                      ->whereYear('waktu_masuk', Carbon::now()->year)
                                      ->count();

        // Kunjungan bulan lalu
        $lastMonthGuestCount = GuestBook::whereMonth('waktu_masuk', Carbon::now()->subMonth()->month)
                                        ->whereYear('waktu_masuk', Carbon::now()->subMonth()->year)
                                        ->count();

        // Persentase Kenaikan/Penurunan Kunjungan
        $growthPercentage = 0;
        if ($lastMonthGuestCount > 0) {
            $growthPercentage = (($monthlyGuestCount - $lastMonthGuestCount) / $lastMonthGuestCount) * 100;
        } elseif ($monthlyGuestCount > 0) {
            $growthPercentage = 100; // Jika bulan lalu kosong, dianggap naik 100%
        }

        // --- Chart Data (Last 7 Days) ---
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D, d M');
            $chartData[] = GuestBook::whereDate('waktu_masuk', $date)->count();
        }

        // --- Visits per Division Data ---
        $divisionVisits = GuestBook::select('divisi_tujuan', DB::raw('count(*) as total'))
                                    ->groupBy('divisi_tujuan')
                                    ->orderBy('total', 'desc')
                                    ->get();

        return view('admin.dashboard', compact(
            'pendingAppointmentsCount',
            'todayGuestCount',
            'monthlyGuestCount',
            'lastMonthGuestCount',
            'growthPercentage',
            'chartLabels',
            'chartData',
            'divisionVisits'
        ));
    }

    /**
     * Displays the list of pending appointments.
     */
    public function listAppointments()
    {
        $appointments = Appointment::where('status', 'pending')->orderBy('tanggal_temu', 'asc')->get();
        return view('admin.appointments', compact('appointments'));
    }

    /**
     * Approves an appointment and records it in the guest book.
     */
    public function approveAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'disetujui']);

        GuestBook::create([
            'appointment_id' => $appointment->id,
            'nama_tamu' => $appointment->nama_tamu,
            'instansi_asal' => $appointment->instansi_asal,
            'divisi_tujuan' => $appointment->divisi_tujuan,
            'keperluan' => $appointment->keperluan,
            'waktu_masuk' => Carbon::parse($appointment->tanggal_temu . ' ' . $appointment->waktu_temu),
            'tipe_kunjungan' => 'janji_temu',
        ]);

        return redirect()->route('admin.appointments')->with('success', 'Janji temu berhasil disetujui.');
    }

    /**
     * Rejects an appointment.
     */
    public function rejectAppointment(Request $request, $id)
    {
        // Ubah min:10 jadi min:3 atau hapus sesuai kebutuhan
        $request->validate([
            'alasan_penolakan' => 'required|string|min:3',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('admin.appointments')->with('success', 'Janji temu telah ditolak.');
    }

    /**
     * Displays the guest book list with filters.
     */
    public function listGuestBook(Request $request)
    {
        $query = GuestBook::with('appointment');

        // Filter Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            if (preg_match('/^(JT|OTS)(\d+)/i', $searchTerm, $matches)) {
                $query->where('id', (int)$matches[2]);
            } else {
                $query->where('nama_tamu', 'like', '%' . $searchTerm . '%');
            }
        }

        // Filter Rentang Tanggal
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $query->where('waktu_masuk', '>=', $startDate);
        }
        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->where('waktu_masuk', '<=', $endDate);
        }

        // Filter Dropdown
        if ($request->filled('divisi')) {
            $query->where('divisi_tujuan', $request->input('divisi'));
        }
        if ($request->filled('tipe')) {
            $query->where('tipe_kunjungan', $request->input('tipe'));
        }

        $divisions = GuestBook::select('divisi_tujuan')->distinct()->orderBy('divisi_tujuan')->get();
        $guests = $query->orderBy('waktu_masuk', 'desc')->paginate(15)->appends($request->query());

        return view('admin.guestbook_list', compact('guests', 'divisions'));
    }
    /**
     * Displays the form for adding an on-the-spot guest.
     */
    public function createGuestForm()
    {
        $divisions = Division::orderBy('name')->get();
        return view('admin.guestbook_form', compact('divisions'));
    }

    /**
     * Stores a new on-the-spot guest.
     */
    public function storeGuest(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'instansi_asal' => 'required|string|max:255',
            'divisi_tujuan' => 'required|string',
            'new_division_name' => 'required_if:divisi_tujuan,other|nullable|string|max:255|unique:divisions,name',
            'keperluan' => 'required|string',
        ]);

        if ($request->divisi_tujuan === 'other') {
            $newDivision = Division::create(['name' => $request->new_division_name]);
            $request->merge(['divisi_tujuan' => $newDivision->name]);
        }

        GuestBook::create([
            'nama_tamu' => $request->nama_tamu,
            'instansi_asal' => $request->instansi_asal,
            'divisi_tujuan' => $request->divisi_tujuan,
            'keperluan' => $request->keperluan,
            'waktu_masuk' => Carbon::now(),
            'tipe_kunjungan' => 'on_the_spot',
        ]);

        return redirect()->route('admin.guestbook')->with('success', 'Tamu on-the-spot berhasil ditambahkan.');
    }

    /**
     * Exports the guest book data to Excel.
     */
    public function exportGuestBook(Request $request)
    {
        // Sesuaikan parameter filter yang dikirim
        $filters = $request->only(['search', 'start_date', 'end_date', 'divisi', 'tipe']);
        $fileName = 'laporan-buku-tamu-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new GuestBookExport($filters), $fileName);
    }
    /**
     * Deletes a single guest book entry.
     */
    public function destroyGuest(Request $request, GuestBook $guest)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors(['password' => 'Kata sandi yang Anda masukkan salah.'])->withInput();
        }
        $guest->delete();
        return redirect()->route('admin.guestbook')->with('success', 'Riwayat kunjungan berhasil dihapus.');
    }

    /**
     * Shows the form for bulk-deleting guest book data.
     */
    public function showDeleteGuestBookForm()
    {
        return view('admin.delete_guestbook_form');
    }

    /**
     * Handles the bulk deletion of guest book data.
     */
    public function bulkDestroyGuestBook(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'tipe_kunjungan' => ['required', 'string', 'in:all,janji_temu,on_the_spot'],
        ]);

        $query = GuestBook::query();
        $bulan = $request->input('bulan');
        $tipe = $request->input('tipe_kunjungan');
        $keteranganFilter = [];

        if ($bulan) {
            // FIX: Konversi $bulan menjadi integer sebelum digunakan
            $query->whereMonth('waktu_masuk', (int)$bulan)->whereYear('waktu_masuk', date('Y'));
            $keteranganFilter[] = "bulan " . Carbon::create()->month((int)$bulan)->translatedFormat('F');
        }

        if ($tipe !== 'all') {
            $query->where('tipe_kunjungan', $tipe);
            $keteranganFilter[] = "tipe " . str_replace('_', ' ', $tipe);
        }

        if (empty($keteranganFilter)) {
             return redirect()->route('admin.guestbook.show_delete_form')->withErrors(['filter' => 'Anda harus memilih setidaknya satu filter untuk menghapus data.']);
        }

        $deletedCount = $query->count();
        if ($deletedCount > 0) {
            $query->delete();
        }

        $pesan = $deletedCount . ' data riwayat kunjungan untuk ' . implode(' dan ', $keteranganFilter) . ' berhasil dihapus secara permanen.';
        return redirect()->route('admin.guestbook')->with('success', $pesan);
    }
}
