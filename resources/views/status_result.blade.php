<x-guest-layout>
    <h2 class="text-center text-2xl font-bold mb-4">Hasil Pengecekan Status</h2>

    @if ($appointment)
        <div class="border rounded-lg p-4 space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Status untuk ID: <strong>{{ $idJanjiTemu }}</strong></span>

                {{-- Badge Status dengan Warna --}}
                @if ($appointment->status == 'disetujui')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                @elseif ($appointment->status == 'ditolak')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                @endif
            </div>

            <hr>

            <p class="text-sm"><strong>Nama Tamu:</strong> {{ $appointment->nama_tamu }}</p>
            <p class="text-sm"><strong>Divisi Tujuan:</strong> {{ $appointment->divisi_tujuan }}</p>
            <p class="text-sm"><strong>Tanggal Temu:</strong> {{ \Carbon\Carbon::parse($appointment->tanggal_temu)->translatedFormat('d F Y') }}</p>

            {{-- Tampilkan alasan jika ditolak --}}
            @if ($appointment->status == 'ditolak')
                <div class="bg-red-50 border-l-4 border-red-400 p-3 mt-2">
                    <p class="text-sm font-semibold text-red-800">Alasan Penolakan:</p>
                    <p class="text-sm text-red-700">{{ $appointment->alasan_penolakan }}</p>
                </div>
            @endif
        </div>
    @else
        {{-- Pesan jika data tidak ditemukan --}}
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <p class="text-sm text-yellow-700">
                Janji temu dengan ID <strong>{{ $idJanjiTemu }}</strong> tidak ditemukan. Pastikan Anda memasukkan ID dengan benar.
            </p>
        </div>
    @endif

    <div class="mt-6 text-center space-x-4">
        <a href="{{ route('status.check.form') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
            Cek ID lain
        </a>
        <span class="text-gray-400">|</span>
        <a href="{{ route('appointment.create') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
            Kembali ke Form Utama
        </a>
    </div>

</x-guest-layout>
