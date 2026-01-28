<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Scripts & Styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        {{-- Container Utama: Grid 1 Kolom di HP, 2 Kolom di Desktop --}}
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

            {{-- Kolom KIRI (Branding - Hanya muncul di Desktop/Laptop) --}}
            <div class="hidden lg:flex flex-col justify-center items-center p-12 text-center text-white bg-gray-800 h-full">
                <div class="max-w-md">
                    <a href="/">
                        {{-- Logo Besar --}}
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Aplikasi" class="w-32 h-auto mx-auto mb-8 drop-shadow-md">
                        <h1 class="text-4xl font-bold mb-4 tracking-tight">
                            SimTamu Diskominfo
                        </h1>
                    </a>
                    <p class="mt-6 text-lg text-gray-300 leading-relaxed">
                        Selamat datang di Sistem Informasi Manajemen Tamu.<br>
                        Silakan isi formulir untuk menjadwalkan kunjungan Anda dengan mudah, cepat, dan terpadu.
                    </p>
                </div>
            </div>

            {{-- Kolom KANAN (Formulir - Muncul di HP dan Desktop) --}}
            <div class="w-full flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-8 lg:p-12 h-full overflow-y-auto">

                {{-- Header Mobile (Logo muncul di atas form saat di HP) --}}
                <div class="lg:hidden mb-8 text-center mt-6">
                     <a href="/" class="flex flex-col items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Aplikasi" class="w-20 h-20 mb-3" />
                        <h1 class="text-2xl font-bold text-gray-800">SimTamu Diskominfo</h1>
                    </a>
                </div>

                {{-- Card Formulir --}}
                <div class="w-full sm:max-w-md bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
                    <div class="px-6 py-8 sm:px-8">
                        {{ $slot }}
                    </div>
                </div>

                {{-- Footer Kecil (Mobile Only) --}}
                <div class="lg:hidden mt-8 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} Diskominfo Garut
                </div>
            </div>

        </div>
    </body>
</html>