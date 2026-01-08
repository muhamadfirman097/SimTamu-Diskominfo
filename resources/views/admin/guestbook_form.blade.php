<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Data Tamu On The Spot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <header class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __('Formulir Buku Tamu') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Isi data untuk tamu yang datang langsung ke kantor.') }}
                        </p>
                    </header>

                    <form action="{{ route('admin.guestbook.store') }}" method="POST" class="space-y-6" x-data="{ selectedDivision: '{{ old('divisi_tujuan') }}' }">
                        @csrf

                        <div>
                            <x-input-label for="nama_tamu" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_tamu" name="nama_tamu" type="text" class="mt-1 block w-full" :value="old('nama_tamu')" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="instansi_asal" :value="__('Asal Instansi/Perusahaan')" />
                            <x-text-input id="instansi_asal" name="instansi_asal" type="text" class="mt-1 block w-full" :value="old('instansi_asal')" required />
                        </div>

                        <div>
                            <x-input-label for="divisi_tujuan" :value="__('Divisi Tujuan')" />
                            <select name="divisi_tujuan" id="divisi_tujuan" x-model="selectedDivision" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled>Pilih Divisi</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->name }}">{{ $division->name }}</option>
                                @endforeach
                                <option value="other">-- Lainnya --</option>
                            </select>
                        </div>

                        <div x-show="selectedDivision === 'other'" x-transition>
                             <x-input-label for="new_division_name_admin" :value="__('Nama Divisi Baru')" />
                             <x-text-input id="new_division_name_admin" name="new_division_name" type="text" class="mt-1 block w-full"
                                    :value="old('new_division_name')"
                                    placeholder="Ketik nama divisi di sini"
                                    x-bind:required="selectedDivision === 'other'" />
                        </div>

                        <div>
                             <x-input-label for="keperluan" :value="__('Keperluan')" />
                             <textarea name="keperluan" id="keperluan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('keperluan') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end pt-4">
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918a4 4 0 01-1.336 1.01l-3.155 1.262a.5.5 0 01-.65-.65z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                                {{ __('Simpan ke Buku Tamu') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
