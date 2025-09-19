<footer class="bg-slate-900 text-slate-300 bottom-0 w-full">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-2xl font-bold text-white font-serif">Aura Bening</h3>
                <p class="mt-2 text-sm text-slate-400">Pengalaman menginap yang tak terlupakan.</p>
            </div>
            
            <div>
                <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase">Jelajahi</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-teal-400 transition-colors">Dashboard</a></li>
                    <li><a href="{{ route('bookings.index') }}" class="hover:text-teal-400 transition-colors">Pemesanan Saya</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-teal-400 transition-colors">Profil</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase">Bantuan</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            
            @if(Auth::user()->role == 'admin')
            <div>
                <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase">Admin Area</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Manajemen Kamar</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Manajemen Pengguna</a></li>
                </ul>
            </div>
            @endif
        </div>

        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} Aura Bening Resort. Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>