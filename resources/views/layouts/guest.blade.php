<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Menggunakan grid 1 kolom di mobile, dan 2 kolom di desktop (lg) --}}
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

            {{-- Kolom Kiri (Deskripsi & Branding, hanya terlihat di desktop) --}}
            <div class="hidden lg:flex flex-col justify-center items-center p-12 text-center text-white bg-gray-800">
                <div class="max-w-md">
                    <a href="/">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Aplikasi" class="w-24 h-auto mx-auto mb-6">
                        <h1 class="text-4xl font-bold mb-4">
                            SimTamu Diskominfo Garut
                        </h1>
                    </a>
                    <p class="mt-4 text-lg text-gray-300 leading-relaxed">
                        Selamat datang di Sistem Informasi Manajemen Tamu. Silakan isi formulir di samping untuk membuat janji temu secara online.
                    </p>
                </div>
            </div>

            {{-- Kolom Kanan (Formulir) --}}
            <div class="w-full flex flex-col justify-center items-center bg-gray-100 p-6 sm:p-8">

                {{-- Header untuk Tampilan Mobile (akan disembunyikan di desktop) --}}
                <div class="lg:hidden mb-6 text-center">
                     <a href="/">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Aplikasi" class="w-20 h-20 mx-auto" />
                         <h1 class="text-2xl font-bold text-gray-800 mt-4">SimTamu Diskominfo Garut</h1>
                    </a>
                </div>

                {{-- Card Formulir --}}
                <div class="w-full sm:max-w-md bg-white shadow-xl overflow-hidden sm:rounded-lg">
                    <div class="px-6 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
