<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku Tamu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-visible shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-data="{ open: false, showDetailModal: false, selectedGuest: null }">

                    {{-- Notifikasi Sukses --}}
                    @if(session('success'))
                        <div x-data="{ showNotif: true }"
                             x-show="showNotif"
                             x-transition:enter="transform transition ease-out duration-300"
                             x-transition:enter-start="-translate-y-4 opacity-0"
                             x-transition:enter-end="translate-y-0 opacity-100"
                             x-transition:leave="transform transition ease-in duration-200"
                             x-transition:leave-start="translate-y-0 opacity-100"
                             x-transition:leave-end="-translate-y-4 opacity-0"
                             class="relative bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4"
                             role="status" aria-live="polite">
                            <p class="font-bold pr-8">{{ session('success') }}</p>

                            <button @click="showNotif = false"
                                    aria-label="Tutup notifikasi"
                                    class="absolute top-2 right-2 inline-flex items-center justify-center w-7 h-7 rounded-full text-green-700 hover:bg-green-200 focus:outline-none">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    {{-- Form Filter --}}
                    <div class="mb-6 relative">
                        <form method="GET" action="{{ route('admin.guestbook') }}">
                            <div class="flex flex-col lg:flex-row gap-4 items-center">
                                
                                <div class="relative flex-grow w-full">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm text-sm" value="{{ request('search') }}" placeholder="Cari ID atau Nama Tamu...">
                                </div>

                                <div class="flex items-center gap-2 w-full lg:w-auto">
                                    <input type="date" name="start_date" id="start_date" class="block w-full lg:w-36 py-2 border-gray-300 rounded-md shadow-sm text-sm text-gray-600" value="{{ request('start_date') }}" title="Tanggal Mulai">
                                    <span class="text-sm text-gray-500">s/d</span>
                                    <input type="date" name="end_date" id="end_date" class="block w-full lg:w-36 py-2 border-gray-300 rounded-md shadow-sm text-sm text-gray-600" value="{{ request('end_date') }}" title="Tanggal Akhir">
                                </div>

                                <div class="relative w-full lg:w-auto">
                                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0113 18v-1.586l-3.707-3.707A1 1 0 009 12V6.414L3.293 4.707A1 1 0 013 4z" /></svg>
                                        Divisi & Tipe
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 top-full mt-2 w-72 bg-white border border-gray-200 rounded-md shadow-lg z-50 p-4 space-y-4" style="display: none;">
                                        <div>
                                            <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                                            <select name="divisi" id="divisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="">Semua Divisi</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->divisi_tujuan }}" {{ request('divisi') == $division->divisi_tujuan ? 'selected' : '' }}>{{ $division->divisi_tujuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Kunjungan</label>
                                            <select name="tipe" id="tipe" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="">Semua Tipe</option>
                                                <option value="janji_temu" {{ request('tipe') == 'janji_temu' ? 'selected' : '' }}>Janji Temu</option>
                                                <option value="on_the_spot" {{ request('tipe') == 'on_the_spot' ? 'selected' : '' }}>On The Spot</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 w-full lg:w-auto">
                                    <button type="submit" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Cari
                                    </button>
                                    <a href="{{ route('admin.guestbook') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Reset
                                    </a>
                                    <a href="{{ route('admin.guestbook.export', request()->query()) }}" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                        Export
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto">
                        {{-- if total data > 10, limit height and enable vertical scroll --}}
                        <div class="{{ $guests->total() > 10 ? 'max-h-96 overflow-y-auto' : '' }}">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">ID Kunjungan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Nama Tamu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Instansi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Divisi Tujuan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Tipe</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Waktu Kunjungan</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($guests as $guest)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                @if ($guest->tipe_kunjungan == 'janji_temu')
                                                    JT{{ str_pad($guest->appointment_id ?? $guest->id, 2, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($guest->nama_tamu, 0, 2)) }}
                                                @else
                                                    OTS{{ str_pad($guest->id, 2, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($guest->nama_tamu, 0, 2)) }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $guest->nama_tamu }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $guest->instansi_asal }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $guest->divisi_tujuan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($guest->tipe_kunjungan == 'janji_temu')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Janji Temu</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">On The Spot</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($guest->waktu_masuk)->translatedFormat('d M Y, H:i') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <button
                                                    type="button"
                                                    title="Detail"
                                                    @click='selectedGuest = @json($guest); showDetailModal = true'
                                                    class="inline-flex items-center p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                                >
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada data kunjungan yang cocok dengan filter atau pencarian.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $guests->links() }}
                    </div>

                    {{-- Modal Detail --}}
                    <div x-show="showDetailModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                        <div @click.away="showDetailModal = false" class="bg-white rounded-lg shadow-xl p-0 w-full max-w-lg mx-4">
                            <div class="flex items-center justify-between p-4 border-b">
                                <h3 class="text-lg font-medium text-gray-900">Detail Kunjungan</h3>
                                <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                            </div>

                            <template x-if="selectedGuest">
                                <div class="p-6 space-y-4 text-sm">
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">ID Kunjungan</span>
                                        <span class="col-span-2 text-gray-800 font-medium" x-text="selectedGuest.tipe_kunjungan === 'janji_temu' ? 'JT' + String(selectedGuest.appointment_id || selectedGuest.id).padStart(2, '0') + '-' + selectedGuest.nama_tamu.substring(0, 2).toUpperCase() : 'OTS' + String(selectedGuest.id).padStart(2, '0') + '-' + selectedGuest.nama_tamu.substring(0, 2).toUpperCase()"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Nama Tamu</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.nama_tamu"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Instansi</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.instansi_asal"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Kontak</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.appointment ? selectedGuest.appointment.kontak : 'Tidak tersedia (OTS)'"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Divisi Tujuan</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.divisi_tujuan"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Waktu Kunjungan</span>
                                        <span class="col-span-2 text-gray-800" x-text="new Date(selectedGuest.waktu_masuk).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' }) + ' WIB'"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <span class="font-semibold text-gray-500">Keperluan</span>
                                        <p class="col-span-2 text-gray-800 whitespace-pre-wrap" x-text="selectedGuest.keperluan"></p>
                                    </div>
                                </div>
                            </template>

                            <div class="px-6 py-4 bg-gray-50 flex justify-end">
                                <x-secondary-button type="button" @click="showDetailModal = false">Tutup</x-secondary-button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
