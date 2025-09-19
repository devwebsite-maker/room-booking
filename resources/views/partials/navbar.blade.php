<nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-slate-800 font-serif">
                        Aura Bening
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition-colors duration-300
                        {{ request()->routeIs('dashboard') ? 'border-teal-500 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }}">
                        Dashboard
                    </a>

                    @if(Auth::user()->role == 'admin')
                        {{-- ====== DROPDOWN MENU UNTUK ADMIN ====== --}}
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition-colors duration-300
                                        {{ request()->routeIs('admin.*') || request()->routeIs('bookings.*') ? 'border-teal-500 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }}">
                                        <div>Data Master</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="py-1 bg-white rounded-xl shadow-lg border border-slate-200">
                                        {{-- PERBAIKAN: Pastikan semua link menggunakan nama route yang benar --}}
                                        <x-dropdown-link :href="route('bookings.index')">
                                            Manajemen Pemesanan
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.rooms.index')">
                                            Manajemen Kamar
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.users.index')">
                                            Manajemen Pengguna
                                        </x-dropdown-link>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>

                    @else
                        {{-- ====== MENU UNTUK SISWA / USER BIASA ====== --}}
                        <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition-colors duration-300
                            {{ request()->routeIs('bookings.*') ? 'border-teal-500 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }}">
                            Pemesanan Saya
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                 <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-slate-600 hover:text-slate-800 focus:outline-none transition-colors duration-150">
                            <div class="w-8 h-8 rounded-full bg-slate-700 text-white flex items-center justify-center text-xs font-bold mr-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="py-1 bg-white rounded-xl shadow-lg border border-slate-200">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Keluar') }}</x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
             @if(Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                
                {{-- PERBAIKAN DI SINI: Ganti route ke bookings.index --}}
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">Manajemen Pemesanan</x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')">Manajemen Kamar</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">Manajemen Pengguna</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">Pemesanan Saya</x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profil') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Keluar') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>