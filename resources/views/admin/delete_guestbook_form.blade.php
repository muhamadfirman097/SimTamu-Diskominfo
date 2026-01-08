<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hapus Data Riwayat Kunjungan') }}
        </h2>
    </x-slot>

    {{-- 1. Inisialisasi Alpine.js untuk state management modal --}}
    <div class="py-12" x-data="{ showConfirmModal: false }">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Menampilkan notifikasi error jika ada --}}
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">Terjadi Kesalahan</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Peringatan --}}
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 3.031-1.742 3.031H4.42c-1.532 0-2.492-1.697-1.742-3.031l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Peringatan: Tindakan Berisiko</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>
                                        Tindakan ini akan menghapus data riwayat kunjungan secara <strong>permanen</strong>. Data yang sudah dihapus tidak dapat dipulihkan kembali. Lanjutkan dengan hati-hati.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Modifikasi form: hapus 'onsubmit' dan tambahkan '@submit.prevent' & 'x-ref' --}}
                    <form method="POST" action="{{ route('admin.guestbook.bulk_destroy') }}" class="mt-6"
                          @submit.prevent="showConfirmModal = true"
                          x-ref="deleteForm">
                        @csrf
                        @method('DELETE')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="bulan" value="Hapus Berdasarkan Bulan (Tahun Ini)" />
                                <select name="bulan" id="bulan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Tidak Dipilih --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <x-input-label for="tipe_kunjungan" value="Hapus Berdasarkan Tipe Kunjungan" />
                                <select name="tipe_kunjungan" id="tipe_kunjungan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="all">Semua Tipe</option>
                                    <option value="janji_temu">Hanya Janji Temu</option>
                                    <option value="on_the_spot">Hanya On The Spot</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                             <x-input-label for="password" value="Konfirmasi dengan Kata Sandi Anda" />
                             <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda" />
                        </div>

                        <div class="mt-8 flex justify-end">
                            {{-- Tombol ini sekarang akan membuka modal, bukan langsung submit --}}
                            <x-danger-button type="submit">
                                Hapus Data Permanen
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 3. Modal Konfirmasi Kustom --}}
        <div x-show="showConfirmModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="showConfirmModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Apakah Anda Yakin?</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Anda akan menghapus data ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button type="button" @click="showConfirmModal = false">
                        Batal
                    </x-secondary-button>
                    {{-- Tombol ini yang akan men-submit form utama --}}
                    <x-danger-button type="button" @click="$refs.deleteForm.submit()">
                        Ya, Hapus Data
                    </x-danger-button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
