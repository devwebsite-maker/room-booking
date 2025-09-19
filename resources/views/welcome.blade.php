<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Bening Resort | Booking Villa & Kamar Modern</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Menambahkan font family kustom ke CSS (Revisi) */
        body {
            font-family: 'Lato', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-700">

<header class="bg-white/80 backdrop-blur-lg fixed top-0 left-0 right-0 z-50 shadow-sm">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-slate-800">Aura Bening</a>
        <ul class="hidden md:flex items-center space-x-8 font-medium">
            <li><a href="#rooms" class="hover:text-teal-600 transition-colors duration-300">Akomodasi</a></li>
            <li><a href="#facilities" class="hover:text-teal-600 transition-colors duration-300">Fasilitas</a></li>
            <li><a href="#gallery" class="hover:text-teal-600 transition-colors duration-300">Galeri</a></li>
            <li><a href="#contact" class="hover:text-teal-600 transition-colors duration-300">Kontak</a></li>
        </ul>
        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('login') }}" class="font-semibold text-slate-700 hover:text-teal-600 transition-colors duration-300">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="bg-teal-500 text-white py-2 px-6 rounded-full font-bold hover:bg-teal-600 transition-all duration-300 hover:scale-105 shadow-lg shadow-teal-500/30">
                Daftar
            </a>
        </div>
    </nav>
</header>

    <main>
        <section class="relative h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative text-center text-white p-4 z-10">
                <h1 class="text-5xl md:text-7xl font-bold mb-4 tracking-tight">Oasis Ketenangan Modern Anda</h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto font-light">Nikmati perpaduan sempurna antara desain kontemporer dan keindahan alam yang asri.</p>
            </div>
        </section>

        <section id="info-unggulan" class="bg-white py-20 -mt-24 relative z-20 mx-4 md:mx-auto max-w-6xl rounded-xl shadow-2xl">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-slate-800 mb-4">Sebuah Pengalaman yang Tak Tertandingi</h2>
        <p class="max-w-3xl mx-auto text-slate-600 mb-16">
            Di Aura Bening Resort, kami mendedikasikan diri untuk menciptakan momen tak terlupakan bagi setiap tamu. Kami memadukan kemewahan modern, pelayanan tulus, dan keindahan alam yang memukau untuk menyajikan sebuah standar baru dalam dunia perhotelan.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-teal-50 text-teal-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Lokasi Premier</h3>
                <p class="text-slate-500">Terletak strategis di antara pantai berpasir putih dan pusat kota yang dinamis, memberikan Anda akses terbaik ke kedua dunia.</p>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-teal-50 text-teal-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Pelayanan Khas</h3>
                <p class="text-slate-500">Tim kami yang profesional dan ramah siap melayani setiap kebutuhan Anda dengan standar layanan bintang lima yang personal.</p>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-teal-50 text-teal-500 mb-4">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Fasilitas Modern</h3>
                <p class="text-slate-500">Mulai dari kolam renang infinity, spa, hingga restoran gourmet, semua fasilitas kami dirancang untuk kesenangan Anda.</p>
            </div>
        </div>
        
        <div class="mt-16">
            <a href="#rooms" class="bg-slate-800 text-white py-3 px-8 rounded-full font-bold hover:bg-slate-900 transition-all duration-300 hover:scale-105 shadow-lg">
                Jelajahi Akomodasi Kami
            </a>
        </div>
    </div>
</section>

        <section id="rooms" class="py-24 bg-slate-50">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-bold mb-4 text-slate-800">Akomodasi Pilihan</h2>
                    <p class="text-slate-600">Setiap kamar dirancang untuk kenyamanan maksimal Anda, menggabungkan estetika modern dengan sentuhan alam.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                        <div class="overflow-hidden">
                           <img src="https://images.unsplash.com/photo-1560185893-a55de8537e4f?auto=format&fit=crop&w=800&q=60" alt="Ocean View Villa" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2 text-slate-800">Ocean View Villa</h3>
                            <p class="text-slate-600 mb-4">Villa pribadi seluas 45m² dengan balkon yang menghadap langsung ke laut lepas.</p>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-2xl font-bold text-teal-600">Rp 1.8jt<small class="font-normal text-slate-500">/malam</small></span>
                                <a href="#" class="font-bold text-teal-500 hover:text-teal-700 transition-colors">Detail Villa &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                        <div class="overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=60" alt="Garden Suite" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2 text-slate-800">Garden Suite</h3>
                            <p class="text-slate-600 mb-4">Suite yang nyaman dengan akses langsung ke taman tropis pribadi yang asri.</p>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-2xl font-bold text-teal-600">Rp 1.3jt<small class="font-normal text-slate-500">/malam</small></span>
                                <a href="#" class="font-bold text-teal-500 hover:text-teal-700 transition-colors">Detail Suite &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                        <div class="overflow-hidden">
                           <img src="https://images.unsplash.com/photo-1590490359854-dfba59ee8bab?auto=format&fit=crop&w=800&q=60" alt="Deluxe Room" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2 text-slate-800">Deluxe Room</h3>
                            <p class="text-slate-600 mb-4">Kamar modern dan efisien, pilihan cerdas untuk pelancong solo maupun pasangan.</p>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-2xl font-bold text-teal-600">Rp 950rb<small class="font-normal text-slate-500">/malam</small></span>
                                <a href="#" class="font-bold text-teal-500 hover:text-teal-700 transition-colors">Detail Kamar &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </main>

    <footer id="contact" class="bg-slate-900 text-slate-300 py-16">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 text-center md:text-left">
            <div class="md:col-span-2">
                <h3 class="text-xl font-bold text-white mb-4">Aura Bening Resort</h3>
                <p class="max-w-md">Destinasi pilihan untuk Anda yang mencari ketenangan dan kemewahan dalam balutan desain modern di tengah keindahan alam.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Jelajahi</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#rooms" class="hover:text-teal-400 transition-colors">Akomodasi</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Restoran</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Karir</a></li>
                </ul>
            </div>
             <div>
                <h3 class="text-lg font-semibold text-white mb-4">Hubungi Kami</h3>
                <ul class="space-y-2">
                    <li><p>info@aurabening.com</p></li>
                    <li><p>(021) 765-4321</p></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-slate-500 mt-12 pt-8 border-t border-slate-800">
            <p>&copy; 2025 Aura Bening Resort. Desain dengan ❤️ di Indonesia.</p>
        </div>
    </footer>

</body>
</html>