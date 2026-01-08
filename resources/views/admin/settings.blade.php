<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Divisi') }}
        </h2>
    </x-slot>

    {{-- State management with Alpine.js for both modals --}}
    <div x-data="{
            showModal: false,
            showDeleteModal: false,
            isEditing: false,
            editItem: { id: null, name: '', kontak: '' },
            formAction: '{{ route('admin.divisions.store') }}',
            deleteFormUrl: ''
        }"
        class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Animated Success Notification --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform ease-in duration-300 transition" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                     class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 flex justify-between items-center shadow-md rounded-md" role="alert">
                    <p class="font-bold">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-green-200 transition">
                        <svg class="w-5 h-5 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endif

            {{-- Animated Error Notification for Delete Password --}}
            @if($errors->has('password_delete'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform ease-in duration-300 transition" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                     class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 flex justify-between items-center shadow-md rounded-md" role="alert">
                    <p class="font-bold">{{ $errors->first('password_delete') }}</p>
                    <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-red-200 transition">
                        <svg class="w-5 h-5 text-red-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Daftar Divisi</h2>
                        {{-- Button to open 'Add Data' modal with icon --}}
                        <x-primary-button @click="isEditing = false; editItem = { id: null, name: '', kontak: '' }; formAction = '{{ route('admin.divisions.store') }}'; showModal = true">
                            <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" /></svg>
                            Tambah Divisi
                        </x-primary-button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Divisi</th>
                                    <th scope="col" class="px-6 py-3">Kontak Divisi</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($divisions as $division)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $division->name }}</td>
                                        <td class="px-6 py-4">{{ $division->kontak ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                {{-- Modern 'Edit' button with icon --}}
                                                <button @click="isEditing = true; editItem = {{ $division }}; formAction = '{{ route('admin.divisions.update', $division) }}'; showModal = true" class="p-2 text-gray-400 hover:text-indigo-600 rounded-full hover:bg-gray-100 transition" title="Edit Divisi">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                {{-- Modern 'Delete' button with icon --}}
                                                <button @click="showDeleteModal = true; deleteFormUrl = '{{ route('admin.divisions.destroy', $division) }}'" class="p-2 text-gray-400 hover:text-red-600 rounded-full hover:bg-gray-100 transition" title="Hapus Divisi">
                                                     <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">Belum ada data divisi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add/Edit Modal --}}
        <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="showModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4" x-text="isEditing ? 'Edit Divisi' : 'Tambah Divisi Baru'"></h3>
                <form :action="formAction" method="POST">
                    @csrf
                    <template x-if="isEditing">@method('PATCH')</template>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="modal_name" value="Nama Divisi" />
                            <x-text-input id="modal_name" name="name" x-model="editItem.name" class="block w-full mt-1" required />
                        </div>
                        <div>
                            <x-input-label for="modal_kontak" value="Kontak Divisi (Opsional)" />
                            <x-text-input id="modal_kontak" name="kontak" x-model="editItem.kontak" class="block w-full mt-1" placeholder="Nama, No. HP, atau Email" />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button type="button" @click="showModal = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="showDeleteModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Anda akan menghapus divisi ini secara permanen. Untuk melanjutkan, masukkan kata sandi Anda.
                </p>
                <form :action="deleteFormUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <div>
                        <x-input-label for="password_delete" value="Kata Sandi Admin" />
                        <x-text-input id="password_delete" name="password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button type="button" @click="showDeleteModal = false">Batal</x-secondary-button>
                        <x-danger-button type="submit">Hapus Divisi</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
