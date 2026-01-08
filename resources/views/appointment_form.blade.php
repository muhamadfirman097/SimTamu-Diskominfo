<x-guest-layout>
    {{-- Inisialisasi Alpine.js untuk state management dropdown "Lainnya" --}}
    <div x-data="{ selectedDivision: '{{ old('divisi_tujuan') }}' }">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Formulir Janji Temu</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan isi detail di bawah untuk menjadwalkan pertemuan Anda.</p>
        </div>

        <form method="POST" action="{{ route('appointment.store') }}" class="space-y-6">
            @csrf

            {{-- 1. Input Nama Lengkap dengan Ikon --}}
            <div>
                <x-input-label for="nama_tamu" value="Nama Lengkap" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                    </div>
                    <x-text-input id="nama_tamu" name="nama_tamu" type="text" class="block w-full pl-10" :value="old('nama_tamu')" required autofocus placeholder="Masukkan nama lengkap Anda" />
                </div>
            </div>

            {{-- 2. Input Instansi dengan Ikon --}}
            <div>
                <x-input-label for="instansi_asal" value="Asal Instansi/Perusahaan" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" /></svg>
                    </div>
                    <x-text-input id="instansi_asal" name="instansi_asal" type="text" class="block w-full pl-10" :value="old('instansi_asal')" required placeholder="Contoh: Universitas Siliwangi" />
                </div>
            </div>

            {{-- 3. Input Kontak dengan Ikon WA (Diperbarui) --}}
            <div>
                <x-input-label for="kontak" value="No. WhatsApp" />
                 <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {{-- IKON BARU --}}
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none">
                                <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-4.863-1.26l-.305-.178l-3.032.892a1.01 1.01 0 0 1-1.28-1.145l.026-.109l.892-3.032A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2m0 2a8 8 0 0 0-6.759 12.282c.198.312.283.696.216 1.077l-.039.163l-.441 1.501l1.501-.441c.433-.128.883-.05 1.24.177A8 8 0 1 0 12 4M9.102 7.184a.7.7 0 0 1 .684.075c.504.368.904.862 1.248 1.344l.327.474l.153.225a.71.71 0 0 1-.046.864l-.075.076l-.924.686a.23.23 0 0 0-.067.291c.21.38.581.947 1.007 1.373c.427.426 1.02.822 1.426 1.055c.088.05.194.034.266-.031l.038-.045l.601-.915a.71.71 0 0 1 .973-.158l.543.379c.54.385 1.059.799 1.47 1.324a.7.7 0 0 1 .089.703c-.396.924-1.399 1.711-2.441 1.673l-.159-.01l-.191-.018l-.108-.014l-.238-.04c-.924-.174-2.405-.698-3.94-2.232c-1.534-1.535-2.058-3.016-2.232-3.94l-.04-.238l-.025-.208l-.013-.175l-.004-.075c-.038-1.044.753-2.047 1.678-2.443" />
                            </g>
                        </svg>
                    </div>
                    <x-text-input id="kontak" name="kontak" type="text" class="block w-full pl-10" :value="old('kontak')" placeholder="Contoh: 08123456789" required />
                </div>
            </div>

            {{-- 4. Dropdown Divisi Tujuan --}}
            <div>
                <x-input-label for="divisi_tujuan" value="Divisi Tujuan" />
                <select name="divisi_tujuan" id="divisi_tujuan" x-model="selectedDivision" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>Pilih Divisi</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->name }}">{{ $division->name }}</option>
                    @endforeach
                    <option value="other">-- Lainnya --</option>
                </select>
            </div>

            {{-- Input Divisi Baru (kondisional) --}}
            <div x-show="selectedDivision === 'other'" x-transition class="!mt-4">
                <x-input-label for="new_division_name" value="Nama Divisi Baru" />
                <x-text-input id="new_division_name" name="new_division_name" type="text" class="mt-1 block w-full" :value="old('new_division_name')"
                       placeholder="Ketik nama divisi di sini"
                       x-bind:required="selectedDivision === 'other'" />
            </div>

            {{-- 5. Text Area Keperluan --}}
            <div>
                <x-input-label for="keperluan" value="Keperluan" />
                <textarea id="keperluan" name="keperluan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('keperluan') }}</textarea>
            </div>

            {{-- 6. Input Tanggal dan Waktu --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="tanggal_temu" value="Tanggal Temu" />
                    <x-text-input id="tanggal_temu" name="tanggal_temu" type="date" class="mt-1 block w-full" :value="old('tanggal_temu')" required />
                </div>
                <div>
                    <x-input-label for="waktu_temu" value="Waktu Temu" />
                    <x-text-input id="waktu_temu" name="waktu_temu" type="time" class="mt-1 block w-full" :value="old('waktu_temu')" required />
                </div>
            </div>

            {{-- 7. Tombol Submit Modern --}}
            <div class="pt-2">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Ajukan Janji Temu
                </button>
            </div>
        </form>

        {{-- Link Cek Status --}}
        <div class="text-center mt-6">
            <span class="text-sm text-gray-500">Ingin cek status janji temu Anda?</span>
            <a href="{{ route('status.check.form') }}" class="text-sm text-gray-600 hover:text-indigo-500 underline">
                Cek status di sini.
            </a>
        </div>
    </div>
</x-guest-layout>
