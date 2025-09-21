<div class="fixed top-0 left-0 right-0 z-50 p-4">
    <nav x-data="{ open: false }" class="max-w-7xl mx-auto bg-white/80 backdrop-blur-md dark:bg-gray-800/80 rounded-full shadow-lg border border-gray-200/80 dark:border-gray-700/80">
        {{-- Primary Navigation Menu --}}
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo & Navigasi Utama --}}
                <div class="flex items-center">
                    {{-- Logo --}}
                    <div class="shrink-0">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2">
                            {{-- Warna ikon diubah ke Indigo --}}
                            <i class="bi bi-building-fill text-2xl text-indigo-600"></i>
                            <span class="text-xl font-bold text-gray-800 dark:text-gray-200 font-serif">RoomBook</span>
                        </a>
                    </div>
                    
                    {{-- Menu Desktop --}}
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        @auth
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            @if(trim(strtolower(optional(Auth::user())->role)) === 'admin')
                                <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index') || request()->routeIs('admin.bookings.verify.view')">
                                    {{ __('Manage Bookings') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')">
                                    {{ __('Manage Rooms') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                    {{ __('Manage Users') }}
                                </x-link>
                                <x-nav-link :href="route('admin.fines.index')" :active="request()->routeIs('admin.fines.index')">
                                    {{ __('Manage Fines') }}
                                </x-nav-link>
                            @else
                                <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')">
                                    {{ __('My Bookings') }}
                                </x-nav-link>
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- Bagian Kanan Navbar (Login/Register atau Profil User) --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    @guest
                        {{-- Tampilan jika user belum login --}}
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300">Log in</a>
                        {{-- Tombol diubah ke warna Indigo --}}
                        <a href="{{ route('register') }}" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Register
                        </a>
                    @else
                        {{-- Tampilan jika user sudah login --}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-600 dark:text-gray-400 bg-transparent hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none transition">
                                    
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</div>