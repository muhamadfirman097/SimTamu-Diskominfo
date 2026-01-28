<x-guest-layout>
    {{-- Inisialisasi Alpine.js --}}
    {{-- Kita cek apakah ada old input (jika validasi gagal) agar form tidak reset --}}
    <div x-data="{ selectedDivision: '{{ old('divisi_tujuan') ?? '' }}' }">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Formulir Kunjungan</h2>
            <p class="text-sm text-gray-500 mt-2">Lengkapi data diri Anda untuk membuat janji temu.</p>
        </div>

        <form method="POST" action="{{ route('appointment.store') }}" class="space-y-5">
            @csrf

            {{-- 1. Nama Lengkap --}}
            <div>
                <x-input-label for="nama_tamu" value="Nama Lengkap" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <x-text-input id="nama_tamu" name="nama_tamu" type="text" class="block w-full pl-10" :value="old('nama_tamu')" required autofocus placeholder="Nama sesuai KTP" />
                </div>
                <x-input-error :messages="$errors->get('nama_tamu')" class="mt-2" />
            </div>

            {{-- 2. Instansi --}}
            <div>
                <x-input-label for="instansi_asal" value="Asal Instansi / Umum" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <x-text-input id="instansi_asal" name="instansi_asal" type="text" class="block w-full pl-10" :value="old('instansi_asal')" required placeholder="Contoh: PT. Maju Jaya / Pribadi" />
                </div>
                <x-input-error :messages="$errors->get('instansi_asal')" class="mt-2" />
            </div>

            {{-- 3. WhatsApp --}}
            <div>
                <x-input-label for="kontak" value="No. WhatsApp (Aktif)" />
                 <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </div>
                    <x-text-input id="kontak" name="kontak" type="number" class="block w-full pl-10" :value="old('kontak')" placeholder="Contoh: 08123xxx" required />
                </div>
                <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
            </div>

            {{-- 4. Divisi Tujuan & Input Lainnya --}}
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <x-input-label for="divisi_tujuan" value="Tujuan Divisi" />
                <select name="divisi_tujuan" id="divisi_tujuan" x-model="selectedDivision" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-10" required>
                    <option value="" disabled selected>-- Pilih Divisi --</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->name }}">{{ $division->name }}</option>
                    @endforeach
                    <option value="other">-- Lainnya (Isi Manual) --</option>
                </select>
                <x-input-error :messages="$errors->get('divisi_tujuan')" class="mt-2" />

                {{-- FORM MUNCUL HANYA JIKA PILIH LAINNYA --}}
                <div x-show="selectedDivision === 'other'" x-cloak x-transition.opacity.duration.300ms class="mt-4 pt-4 border-t border-gray-200">
                    <x-input-label for="new_division_name" value="Masukkan Nama Divisi" class="text-indigo-600" />
                    <x-text-input id="new_division_name" name="new_division_name" type="text" class="mt-1 block w-full border-indigo-300 focus:ring-indigo-200" :value="old('new_division_name')"
                            placeholder="Ketik nama divisi tujuan..."
                            {{-- Tambahkan required via Alpine agar browser tidak komplain saat hidden --}}
                            x-bind:required="selectedDivision === 'other'" />
                    <x-input-error :messages="$errors->get('new_division_name')" class="mt-2" />
                </div>
            </div>

            {{-- 5. Keperluan --}}
            <div>
                <x-input-label for="keperluan" value="Keperluan Bertamu" />
                <textarea id="keperluan" name="keperluan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Jelaskan secara singkat keperluan Anda...">{{ old('keperluan') }}</textarea>
                <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
            </div>

            {{-- 6. Tanggal & Waktu (Responsive Grid) --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tanggal_temu" value="Tanggal" />
                    <x-text-input id="tanggal_temu" name="tanggal_temu" type="date" class="mt-1 block w-full" :value="old('tanggal_temu')" required />
                </div>
                <div>
                    <x-input-label for="waktu_temu" value="Jam" />
                    <x-text-input id="waktu_temu" name="waktu_temu" type="time" class="mt-1 block w-full" :value="old('waktu_temu')" required />
                </div>
            </div>

            {{-- 7. Submit Button --}}
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    Buat Janji Temu
                </button>
            </div>
        </form>

        {{-- Footer Cek Status --}}
        <div class="mt-6 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-600">Sudah pernah buat janji?</p>
            <a href="{{ route('status.check.form') }}" class="inline-block mt-1 text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                &rarr; Cek Status Pengajuan
            </a>
        </div>
    </div>
</x-guest-layout>