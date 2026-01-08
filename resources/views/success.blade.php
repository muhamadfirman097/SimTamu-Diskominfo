<x-guest-layout>
    {{-- Inisialisasi Alpine.js untuk notifikasi dan logika penyalinan --}}
    <div class="text-center p-6 sm:p-8" x-data="{ copied: false }">

        {{-- Notifikasi "Tersalin" yang akan muncul di bagian atas layar --}}
        <div x-show="copied"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-4 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm py-2 px-4 rounded-full shadow-lg z-50"
             style="display: none;">
            Kode janji temu berhasil disalin!
        </div>

        {{-- Header dengan Ikon Centang --}}
        <div class="flex justify-center items-center mx-auto w-16 h-16 bg-green-100 rounded-full mb-5">
            <svg class="w-10 h-10 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900">Pengajuan Terkirim!</h2>
        <p class="mt-2 text-md text-gray-600">
            Terima kasih! Janji temu Anda telah berhasil kami terima.
        </p>

        @if (session('janjiTemuId'))
            <div class="mt-6 space-y-4">
                {{-- Kotak Kode Janji Temu dengan Tombol Salin --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 relative text-center">
                    <p class="text-sm text-gray-600">Kode Janji Temu Anda:</p>
                    <span id="appointmentId" class="text-2xl font-bold text-indigo-700 tracking-wider">{{ session('janjiTemuId') }}</span>

                    {{-- Tombol Salin dengan Ikon baru (warna diubah menjadi currentColor) --}}
                    <button
                        type="button"
                        title="Salin Kode"
                        @click="
                            navigator.clipboard.writeText(document.getElementById('appointmentId').innerText);
                            copied = true;
                            setTimeout(() => copied = false, 2500);
                        "
                        class="absolute top-1/2 right-3 -translate-y-1/2 p-2 text-gray-500 hover:text-indigo-700 rounded-full hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19.53 8L14 2.47a.75.75 0 0 0-.53-.22H11A2.75 2.75 0 0 0 8.25 5v1.25H7A2.75 2.75 0 0 0 4.25 9v10A2.75 2.75 0 0 0 7 21.75h7A2.75 2.75 0 0 0 16.75 19v-1.25H17A2.75 2.75 0 0 0 19.75 15V8.5a.75.75 0 0 0-.22-.5m-5.28-3.19l2.94 2.94h-2.94Zm1 14.19A1.25 1.25 0 0 1 14 20.25H7A1.25 1.25 0 0 1 5.75 19V9A1.25 1.25 0 0 1 7 7.75h1.25V15A2.75 2.75 0 0 0 11 17.75h4.25ZM17 16.25h-6A1.25 1.25 0 0 1 9.75 15V5A1.25 1.25 0 0 1 11 3.75h1.75V8.5a.76.76 0 0 0 .75.75h4.75V15A1.25 1.25 0 0 1 17 16.25"/></svg>
                    </button>
                </div>

                {{-- Pesan Peringatan --}}
                <div class="flex items-start bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 text-left">
                        <p class="text-sm text-yellow-800">
                            <strong>Penting:</strong> Mohon simpan atau salin kode di atas untuk melakukan pengecekan status janji temu Anda.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="mt-8 space-y-3">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Diskominfo%20Garut,%20saya%20ingin%20bertanya%20mengenai%20janji%20temu%20dengan%20kode%20{{ session('janjiTemuId') }}"
               target="_blank"
               class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{-- Ikon WhatsApp Baru --}}
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none"><path fill="#fff" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-4.863-1.26l-.305-.178l-3.032.892a1.01 1.01 0 0 1-1.28-1.145l.026-.109l.892-3.032A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2m0 2a8 8 0 0 0-6.759 12.282c.198.312.283.696.216 1.077l-.039.163l-.441 1.501l1.501-.441c.433-.128.883-.05 1.24.177A8 8 0 1 0 12 4M9.102 7.184a.7.7 0 0 1 .684.075c.504.368.904.862 1.248 1.344l.327.474l.153.225a.71.71 0 0 1-.046.864l-.075.076l-.924.686a.23.23 0 0 0-.067.291c.21.38.581.947 1.007 1.373c.427.426 1.02.822 1.426 1.055c.088.05.194.034.266-.031l.038-.045l.601-.915a.71.71 0 0 1 .973-.158l.543.379c.54.385 1.059.799 1.47 1.324a.7.7 0 0 1 .089.703c-.396.924-1.399 1.711-2.441 1.673l-.159-.01l-.191-.018l-.108-.014l-.238-.04c-.924-.174-2.405-.698-3.94-2.232c-1.534-1.535-2.058-3.016-2.232-3.94l-.04-.238l-.025-.208l-.013-.175l-.004-.075c-.038-1.044.753-2.047 1.678-2.443"/></g></svg>
                Hubungi via WhatsApp
            </a>
            <a href="{{ route('status.check.form') }}"
               class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{-- Ikon Cek Status Baru --}}
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#fff" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5A6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                Cek Status Janji Temu
            </a>
            <a href="{{ url('/') }}"
               class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{-- Ikon Kembali ke Halaman Utama Baru --}}
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><path id="SVGEuPeJeiy" fill="#fff" d="M10.75 9.5a1.25 1.25 0 1 1 2.5 0a1.25 1.25 0 0 1-2.5 0"/></defs><path fill="#fff" d="M18.5 3H16a.5.5 0 0 0-.5.5v.059l3.5 2.8V3.5a.5.5 0 0 0-.5-.5"/><use href="#SVGEuPeJeiy" fill-rule="evenodd" clip-rule="evenodd"/><path fill="#fff" fill-rule="evenodd" d="m20.75 10.96l.782.626a.75.75 0 0 0 .936-1.172l-8.125-6.5a3.75 3.75 0 0 0-4.686 0l-8.125 6.5a.75.75 0 0 0 .937 1.172l.781-.626v10.29H2a.75.75 0 0 0 0 1.5h20a.75.75 0 0 0 0-1.5h-1.25zM9.25 9.5a2.75 2.75 0 1 1 5.5 0a2.75 2.75 0 0 1-5.5 0m2.8 3.75c.664 0 1.237 0 1.696.062c.492.066.963.215 1.345.597s.531.853.597 1.345c.058.43.062.96.062 1.573v4.423h-1.5V17c0-.728-.002-1.2-.048-1.546c-.044-.325-.114-.427-.172-.484s-.159-.128-.484-.172c-.347-.046-.818-.048-1.546-.048s-1.2.002-1.546.048c-.325.044-.427.115-.484.172s-.128.159-.172.484c-.046.347-.048.818-.048 1.546v4.25h-1.5v-4.3c0-.664 0-1.237.062-1.696c.066-.492.215-.963.597-1.345s.854-.531 1.345-.597c.459-.062 1.032-.062 1.697-.062z" clip-rule="evenodd"/><use href="#SVGEuPeJeiy" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</x-guest-layout>
