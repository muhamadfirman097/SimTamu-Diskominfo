<div class="flex flex-col h-full">

    {{-- Header Logo dan Judul --}}
    <div class="flex items-center justify-center h-16 border-b border-gray-700 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center overflow-hidden">
            <x-application-logo class="block h-9 w-auto fill-current text-white flex-shrink-0" />
            <span class="ml-3 text-white font-semibold text-lg whitespace-nowrap" x-show="isSidebarExpanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">SimTamu</span>
        </a>
    </div>

    {{-- Menu Navigasi Utama (Flex Grow) --}}
    <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
        {{-- Dashboard Link --}}
        <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" x-bind:is-expanded="isSidebarExpanded">
            <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M4 19v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-3q-.425 0-.712-.288T14 20v-5q0-.425-.288-.712T13 14h-2q-.425 0-.712.288T10 15v5q0 .425-.288.713T9 21H6q-.825 0-1.412-.587T4 19"/></svg>
            <span class="ml-3 whitespace-nowrap" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Dashboard') }}</span>
        </x-side-nav-link>

        {{-- Janji Temu Link --}}
        <x-side-nav-link :href="route('admin.appointments')" :active="request()->routeIs('admin.appointments')" x-bind:is-expanded="isSidebarExpanded">
            <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M8 5H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5.697M18 14v4h4m-4-7V7a2 2 0 0 0-2-2h-2"/><path d="M8 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2m6 13a4 4 0 1 0 8 0a4 4 0 1 0-8 0m-6-7h4m-4 4h3"/></g></svg>
            <span class="ml-3 whitespace-nowrap flex-1" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Janji Temu') }}</span>
            @if($pendingAppointmentsCount > 0)
                <span id="appointment-badge" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full" x-show="isSidebarExpanded" x-transition.opacity>
                    {{ $pendingAppointmentsCount }}
                </span>
            @else
                <span id="appointment-badge" class="hidden">0</span>
            @endif
        </x-side-nav-link>

        {{-- Buku Tamu Link --}}
        <x-side-nav-link :href="route('admin.guestbook')" :active="request()->routeIs('admin.guestbook')" x-bind:is-expanded="isSidebarExpanded">
            <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M3.255 3.667A1.01 1.01 0 0 1 4.022 2H16.5a4.5 4.5 0 1 1 0 9H4.022a1.01 1.01 0 0 1-.767-1.667l.754-.88a3 3 0 0 0 0-3.905l-.754-.88ZM6.062 4a5 5 0 0 1 0 5H16.5a2.5 2.5 0 0 0 0-5zM3 16.5A4.5 4.5 0 0 1 7.5 12h12.478a1.01 1.01 0 0 1 .767 1.667l-.755.88a3 3 0 0 0 0 3.905l.755.88A1.01 1.01 0 0 1 19.978 21H7.5A4.5 4.5 0 0 1 3 16.5M7.5 14a2.5 2.5 0 0 0 0 5h10.438a5 5 0 0 1 0-5z"/></g></svg>
            <span class="ml-3 whitespace-nowrap" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Buku Tamu') }}</span>
        </x-side-nav-link>

        {{-- Input Tamu OTS Link --}}
        <x-side-nav-link :href="route('admin.guestbook.create')" :active="request()->routeIs('admin.guestbook.create')" x-bind:is-expanded="isSidebarExpanded">
            <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10h-4V6a2 2 0 0 0-4 0l.071 4H6a2 2 0 0 0 0 4l4.071-.071L10 18a2 2 0 0 0 4 0v-4.071L18 14a2 2 0 0 0 0-4"/></svg>
            <span class="ml-3 whitespace-nowrap" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Input Tamu OTS') }}</span>
        </x-side-nav-link>

        {{-- Manajemen Divisi Link --}}
        <x-side-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" x-bind:is-expanded="isSidebarExpanded">
            <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor" d="M15 20H9a3 3 0 0 0-3 3v2h2v-2a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2h2v-2a3 3 0 0 0-3-3m-3-1a4 4 0 1 0-4-4a4 4 0 0 0 4 4m0-6a2 2 0 1 1-2 2a2 2 0 0 1 2-2"/><path fill="currentColor" d="M28 19v9H4V8h12V6H4a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2v-9Z"/><path fill="currentColor" d="M20 19h6v2h-6zm2 4h4v2h-4zm10-13V8h-2.101a5 5 0 0 0-.732-1.753l1.49-1.49l-1.414-1.414l-1.49 1.49A5 5 0 0 0 26 4.101V2h-2v2.101a5 5 0 0 0-1.753.732l-1.49-1.49l-1.414 1.414l1.49 1.49A5 5 0 0 0 20.101 8H18v2h2.101a5 5 0 0 0 .732 1.753l-1.49 1.49l1.414 1.414l1.49-1.49a5 5 0 0 0 1.753.732V16h2v-2.101a5 5 0 0 0 1.753-.732l1.49 1.49l1.414-1.414l-1.49-1.49A5 5 0 0 0 29.899 10zm-7 2a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3"/></svg>
            <span class="ml-3 whitespace-nowrap" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Manajemen Divisi') }}</span>
        </x-side-nav-link>

        {{-- Hapus Data Kunjungan Link --}}
        <div class="pt-2 mt-2 border-t border-gray-700">
             <x-side-nav-link :href="route('admin.guestbook.show_delete_form')" :active="request()->routeIs('admin.guestbook.show_delete_form')" class="text-red-400 hover:bg-red-800 hover:text-white" x-bind:is-expanded="isSidebarExpanded">
                <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12"><path fill="currentColor" d="M5 3h2a1 1 0 0 0-2 0M4 3a2 2 0 1 1 4 0h2.5a.5.5 0 0 1 0 1h-.441l-.443 5.17A2 2 0 0 1 7.623 11H4.377a2 2 0 0 1-1.993-1.83L1.941 4H1.5a.5.5 0 0 1 0-1zm3.5 3a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0zM5 5.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M3.38 9.085a1 1 0 0 0 .997.915h3.246a1 1 0 0 0 .996-.915L9.055 4h-6.11z"/></svg>
                <span class="ml-3 whitespace-nowrap" x-show="isSidebarExpanded" x-transition.opacity>{{ __('Hapus Data Kunjungan') }}</span>
            </x-side-nav-link>
        </div>
    </nav>

    {{-- User Menu --}}
    <div class="px-2 pt-2 pb-2 border-t border-gray-700 flex-shrink-0">
         <x-dropdown align="top" width="48">
             <x-slot name="trigger">
                 <button class="w-full flex items-center p-2 text-sm font-medium text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white" :class="isSidebarExpanded ? 'justify-start' : 'justify-center'">
                    <svg class="w-7 h-6 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <div class="ml-3 text-left overflow-hidden" x-show="isSidebarExpanded" x-transition.opacity>
                        <p class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-gray-400">Admin</p>
                    </div>
                </button>
             </x-slot>
             <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">{{ __('Profil') }}</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
             </x-slot>
         </x-dropdown>
    </div>
</div>

