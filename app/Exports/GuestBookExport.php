<?php

namespace App\Exports;

use App\Models\GuestBook;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class GuestBookExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    // Menerima filter dari controller
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    // Mendefinisikan header kolom di file Excel
    public function headings(): array
    {
        return [
            'ID Kunjungan',
            'Nama Tamu',
            'Instansi Asal',
            'Divisi Tujuan',
            'Tipe Kunjungan',
            'Waktu Kunjungan',
            'Keperluan',
        ];
    }

    // Memformat setiap baris data
    public function map($guest): array
    {
        // Membuat ID Kunjungan
        if ($guest->tipe_kunjungan == 'janji_temu') {
            // Menggunakan appointment_id agar sinkron dengan ID di tampilan View tabel web
            $id = $guest->appointment_id ?? $guest->id;
            $idKunjungan = 'JT' . str_pad($id, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr($guest->nama_tamu, 0, 2));
        } else {
            // Tamu On The Spot menggunakan ID dari tabel guest_books
            $idKunjungan = 'OTS' . str_pad($guest->id, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr($guest->nama_tamu, 0, 2));
        }

        return [
            $idKunjungan,
            $guest->nama_tamu,
            $guest->instansi_asal,
            $guest->divisi_tujuan,
            ucwords(str_replace('_', ' ', $guest->tipe_kunjungan)),
            Carbon::parse($guest->waktu_masuk)->format('d-m-Y H:i'),
            $guest->keperluan,
        ];
    }

    // Query ke database dengan menerapkan filter
    public function query()
    {
        $query = GuestBook::query();

        // Menerapkan filter pencarian
        if (!empty($this->filters['search'])) {
             $searchTerm = $this->filters['search'];
             if (preg_match('/^(JT|OTS)(\d+)/i', $searchTerm, $matches)) {
                $query->where('id', (int)$matches[2]);
            } else {
                $query->where('nama_tamu', 'like', '%' . $searchTerm . '%');
            }
        }
        
        // Menerapkan filter Rentang Tanggal (Start Date & End Date)
        if (!empty($this->filters['start_date'])) {
            $startDate = Carbon::parse($this->filters['start_date'])->startOfDay();
            $query->where('waktu_masuk', '>=', $startDate);
        }
        
        if (!empty($this->filters['end_date'])) {
            $endDate = Carbon::parse($this->filters['end_date'])->endOfDay();
            $query->where('waktu_masuk', '<=', $endDate);
        }

        // Menerapkan filter Dropdown Divisi & Tipe
        if (!empty($this->filters['divisi'])) {
            $query->where('divisi_tujuan', $this->filters['divisi']);
        }
        
        if (!empty($this->filters['tipe'])) {
            $query->where('tipe_kunjungan', $this->filters['tipe']);
        }

        return $query->orderBy('waktu_masuk', 'desc');
    }
}
