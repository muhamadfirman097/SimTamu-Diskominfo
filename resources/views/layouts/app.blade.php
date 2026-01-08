<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>[x-cloak]{display:none !important;}</style>

        {{-- AlpineJS (tanpa plugin persist) --}}
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>
    <body class="font-sans antialiased">

        {{-- 1. State 'isSidebarExpanded' diatur oleh hover, default-nya false (ciut) --}}
        <div x-data="{ isSidebarExpanded: false }" class="flex h-screen bg-gray-100">

            {{-- 2. Tambahkan @mouseenter dan @mouseleave untuk mengontrol state --}}
            <aside
                @mouseenter="isSidebarExpanded = true"
                @mouseleave="isSidebarExpanded = false"
                class="fixed inset-y-0 left-0 z-30 bg-gray-800 text-white transform transition-all duration-300 ease-in-out lg:static lg:inset-0"
                :class="isSidebarExpanded ? 'w-64' : 'w-20'">

                @include('layouts.navigation')

            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center">

                        {{-- Tombol ini tetap ada untuk fungsionalitas di perangkat mobile --}}
                        <button @click="isSidebarExpanded = !isSidebarExpanded" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const badge = document.getElementById('appointment-badge');

                // Pastikan Echo sudah dimuat
                if (typeof window.Echo !== 'undefined') {
                    if (badge) {
                        window.Echo.private('admin-notifications')
                            .listen('.new.appointment', (e) => {
                                console.log('Event diterima!', e); // Untuk debugging

                                // 1. Logika untuk update badge (sudah ada)
                                badge.innerText = e.pendingAppointmentsCount;
                                if (e.pendingAppointmentsCount > 0) {
                                    badge.classList.remove('hidden');
                                } else {
                                    badge.classList.add('hidden');
                                }

                                // 2. LOGIKA DIPERBARUI:
                                // Cek apakah kita sedang di halaman 'admin/appointments'
                                // (Dibuat lebih robust untuk menangani trailing slash '/')
                                let currentPath = window.location.pathname;
                                if (currentPath.endsWith('/')) {
                                    currentPath = currentPath.slice(0, -1);
                                }

                                if (currentPath === '/admin/appointments') {
                                    // Jika iya, reload halaman untuk menampilkan data baru
                                    console.log('Reloading page...');
                                    location.reload();
                                }
                            });
                    }
                } else {
                    console.error('Laravel Echo is not defined. Make sure bootstrap.js is loaded.');
                }
            });
        </script>
        @endauth

    </body>
</html>

