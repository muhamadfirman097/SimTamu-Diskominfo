<?php

namespace App\Exports;

use App\Models\GuestBook;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

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
            $idKunjungan = 'JT' . str_pad($guest->id, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr($guest->nama_tamu, 0, 2));
        } else {
            $idKunjungan = 'OTS' . str_pad($guest->id, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr($guest->nama_tamu, 0, 2));
        }

        return [
            $idKunjungan,
            $guest->nama_tamu,
            $guest->instansi_asal,
            $guest->divisi_tujuan,
            ucwords(str_replace('_', ' ', $guest->tipe_kunjungan)),
            \Carbon\Carbon::parse($guest->waktu_masuk)->format('d-m-Y H:i'),
            $guest->keperluan,
        ];
    }

    // Query ke database dengan menerapkan filter
    public function query()
    {
        $query = GuestBook::query();

        // Menerapkan filter yang sama persis seperti di controller
        if (!empty($this->filters['search'])) {
             $searchTerm = $this->filters['search'];
             if (preg_match('/^(JT|OTS)(\d+)/i', $searchTerm, $matches)) {
                $query->where('id', (int)$matches[2]);
            } else {
                $query->where('nama_tamu', 'like', '%' . $searchTerm . '%');
            }
        }
        if (!empty($this->filters['bulan'])) {
            $query->whereMonth('waktu_masuk', $this->filters['bulan'])->whereYear('waktu_masuk', date('Y'));
        }
        if (!empty($this->filters['divisi'])) {
            $query->where('divisi_tujuan', $this->filters['divisi']);
        }
        if (!empty($this->filters['tipe'])) {
            $query->where('tipe_kunjungan', $this->filters['tipe']);
        }

        return $query->orderBy('waktu_masuk', 'desc');
    }
}
