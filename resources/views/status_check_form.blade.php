<x-guest-layout>
    <h2 class="text-center text-2xl font-bold mb-6">Cek Status Janji Temu</h2>

    <form method="POST" action="{{ route('status.check') }}">
        @csrf
        <div>
            <label class="block font-medium text-sm text-gray-700" for="id_janji_temu">
                ID Janji Temu
            </label>
            <input id="id_janji_temu" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                   type="text" name="id_janji_temu" placeholder="Contoh: JT01-MU" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Cari Janji Temu
            </button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('appointment.create') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
            Kembali ke Form Utama
        </a>
    </div>

</x-guest-layout>
