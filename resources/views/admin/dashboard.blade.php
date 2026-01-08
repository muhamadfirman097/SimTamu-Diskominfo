<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Anda dapat mengelola data janji temu dan buku tamu Diskominfo Garut melalui halaman ini.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border-l-4 border-yellow-400 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Janji Temu Pending</dt>
                                    <dd>
                                        {{-- 1. ID BARU DITAMBAHKAN DI SINI --}}
                                        <div class="text-2xl font-semibold text-gray-900" id="dashboard-pending-count">
                                            {{ $pendingAppointmentsCount }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-l-4 border-blue-400 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                               <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Kunjungan Hari Ini</dt><dd><div class="text-2xl font-semibold text-gray-900">{{ $todayGuestCount }}</div></dd></dl></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-l-4 border-green-400 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Total Tamu Bulan Ini</dt><dd><div class="text-2xl font-semibold text-gray-900">{{ $monthlyGuestCount }}</div></dd></dl></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Grafik Kunjungan (7 Hari Terakhir)</h3>
                    <div>
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Kunjungan per Divisi</h3>
                    <div class="space-y-4">
                        @forelse ($divisionVisits as $visit)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">{{ $visit->divisi_tujuan }}</span>
                                <span class="text-sm font-semibold text-gray-800 bg-gray-200 px-2 py-1 rounded">{{ $visit->total }} Tamu</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data kunjungan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('visitsChart').getContext('2d');
            const visitsChart = new Chart(ctx, {
                type: 'line', // Tipe chart: garis
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: @json($chartData),
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3, // Membuat garis sedikit melengkung
                        fill: true,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Memastikan hanya angka bulat di sumbu Y
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Menyembunyikan label dataset di atas
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

