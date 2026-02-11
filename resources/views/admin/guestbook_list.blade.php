<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Buku Tamu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-visible shadow-lg shadow-gray-200/50 sm:rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8 text-gray-900" x-data="{ open: false, showDetailModal: false, selectedGuest: null }">

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
                             class="relative bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-sm"
                             role="status" aria-live="polite">
                            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-medium pr-8">{{ session('success') }}</p>

                            <button @click="showNotif = false"
                                    aria-label="Tutup notifikasi"
                                    class="absolute top-1/2 -translate-y-1/2 right-4 inline-flex items-center justify-center w-8 h-8 rounded-lg text-emerald-600 hover:bg-emerald-100 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    {{-- Form Filter Section --}}
                    <div class="mb-8 relative bg-gray-50/50 p-4 sm:p-5 rounded-xl border border-gray-100">
                        <form method="GET" action="{{ route('admin.guestbook') }}">
                            <div class="flex flex-col lg:flex-row gap-4 items-center">
                                
                                <div class="relative flex-grow w-full">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <input type="text" name="search" id="search" class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200" value="{{ request('search') }}" placeholder="Cari ID atau Nama Tamu...">
                                </div>

                                <div class="flex items-center gap-2 w-full lg:w-auto">
                                    <input type="date" name="start_date" id="start_date" class="block w-full lg:w-36 py-2.5 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 transition-colors duration-200" value="{{ request('start_date') }}" title="Tanggal Mulai">
                                    <span class="text-sm font-medium text-gray-400">s/d</span>
                                    <input type="date" name="end_date" id="end_date" class="block w-full lg:w-36 py-2.5 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 transition-colors duration-200" value="{{ request('end_date') }}" title="Tanggal Akhir">
                                </div>

                                <div class="relative w-full lg:w-auto">
                                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2.5 border border-blue-200 shadow-sm text-sm font-semibold rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0113 18v-1.586l-3.707-3.707A1 1 0 009 12V6.414L3.293 4.707A1 1 0 013 4z" /></svg>
                                        Divisi & Tipe
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 top-full mt-2 w-72 bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-5 space-y-4" style="display: none;">
                                        <div>
                                            <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Divisi Tujuan</label>
                                            <select name="divisi" id="divisi" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">Semua Divisi</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->divisi_tujuan }}" {{ request('divisi') == $division->divisi_tujuan ? 'selected' : '' }}>{{ $division->divisi_tujuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kunjungan</label>
                                            <select name="tipe" id="tipe" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">Semua Tipe</option>
                                                <option value="janji_temu" {{ request('tipe') == 'janji_temu' ? 'selected' : '' }}>Janji Temu</option>
                                                <option value="on_the_spot" {{ request('tipe') == 'on_the_spot' ? 'selected' : '' }}>On The Spot</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 w-full lg:w-auto">
                                    <button type="submit" class="inline-flex items-center justify-center w-full lg:w-auto px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg shadow-md shadow-blue-500/30 text-sm font-semibold text-white tracking-wide hover:bg-blue-700 focus:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                        Cari
                                    </button>
                                    <a href="{{ route('admin.guestbook') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        Reset
                                    </a>
                                    <a href="{{ route('admin.guestbook.export', request()->query()) }}" class="inline-flex items-center justify-center w-full lg:w-auto px-4 py-2.5 border border-emerald-200 shadow-sm text-sm font-semibold rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 hover:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2 stroke-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                        Export
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-hidden border border-gray-200 rounded-xl">
                        {{-- if total data > 10, limit height and enable vertical scroll --}}
                        <div class="{{ $guests->total() > 10 ? 'max-h-[32rem] overflow-y-auto' : 'overflow-x-auto' }}">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">ID Kunjungan</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Nama Tamu</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Instansi</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Divisi Tujuan</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Tipe</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Waktu Kunjungan</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider sticky top-0 bg-slate-50 z-20 shadow-sm">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse ($guests as $guest)
                                        <tr class="hover:bg-blue-50/50 transition-colors duration-150 group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                                @if ($guest->tipe_kunjungan == 'janji_temu')
                                                    JT{{ str_pad($guest->appointment_id ?? $guest->id, 2, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($guest->nama_tamu, 0, 2)) }}
                                                @else
                                                    OTS{{ str_pad($guest->id, 2, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($guest->nama_tamu, 0, 2)) }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{ $guest->nama_tamu }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $guest->instansi_asal }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $guest->divisi_tujuan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($guest->tipe_kunjungan == 'janji_temu')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">Janji Temu</span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">On The Spot</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($guest->waktu_masuk)->translatedFormat('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <button
                                                    type="button"
                                                    title="Lihat Detail"
                                                    @click='selectedGuest = @json($guest); showDetailModal = true'
                                                    class="inline-flex items-center p-2 rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                                                >
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 bg-gray-50/50">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <p class="text-base font-medium">Tidak ada data kunjungan ditemukan.</p>
                                                    <p class="text-sm mt-1">Silakan sesuaikan filter atau kata kunci pencarian Anda.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($guests->hasPages())
                        <div class="mt-6">
                            {{ $guests->links() }}
                        </div>
                    @endif

                    {{-- Modal Detail --}}
                    <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" style="display: none;">
                        <div @click.away="showDetailModal = false" x-show="showDetailModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95" class="bg-white rounded-2xl shadow-2xl p-0 w-full max-w-lg mx-4 overflow-hidden border border-gray-100">
                            
                            <div class="flex items-center justify-between px-6 py-4 bg-blue-50/50 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-blue-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Detail Kunjungan
                                </h3>
                                <button @click="showDetailModal = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <template x-if="selectedGuest">
                                <div class="px-6 py-5 space-y-4 text-sm">
                                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <span class="font-medium text-gray-500">ID Kunjungan</span>
                                        <span class="text-blue-700 font-bold text-base bg-blue-100 px-3 py-1 rounded-md" x-text="selectedGuest.tipe_kunjungan === 'janji_temu' ? 'JT' + String(selectedGuest.appointment_id || selectedGuest.id).padStart(2, '0') + '-' + selectedGuest.nama_tamu.substring(0, 2).toUpperCase() : 'OTS' + String(selectedGuest.id).padStart(2, '0') + '-' + selectedGuest.nama_tamu.substring(0, 2).toUpperCase()"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50">
                                        <span class="font-medium text-gray-500">Nama Tamu</span>
                                        <span class="col-span-2 text-gray-900 font-semibold" x-text="selectedGuest.nama_tamu"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50">
                                        <span class="font-medium text-gray-500">Instansi / Asal</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.instansi_asal"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50">
                                        <span class="font-medium text-gray-500">Nomor Kontak</span>
                                        <span class="col-span-2 text-gray-800" x-text="selectedGuest.appointment ? selectedGuest.appointment.kontak : 'Tidak tersedia (On The Spot)'"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50">
                                        <span class="font-medium text-gray-500">Divisi Tujuan</span>
                                        <span class="col-span-2 text-gray-800 font-medium" x-text="selectedGuest.divisi_tujuan"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50">
                                        <span class="font-medium text-gray-500">Waktu Kedatangan</span>
                                        <span class="col-span-2 text-gray-800" x-text="new Date(selectedGuest.waktu_masuk).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' }) + ' WIB'"></span>
                                    </div>
                                    <div class="pt-2">
                                        <span class="block font-medium text-gray-500 mb-2">Keperluan:</span>
                                        <p class="text-gray-800 bg-blue-50/50 border border-blue-100 rounded-lg p-3 whitespace-pre-wrap leading-relaxed" x-text="selectedGuest.keperluan"></p>
                                    </div>
                                </div>
                            </template>

                            <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100 flex justify-end">
                                <button type="button" @click="showDetailModal = false" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    Tutup Detail
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
