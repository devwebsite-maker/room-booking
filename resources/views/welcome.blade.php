<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RoomBook - Your Perfect Stay Awaits</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans">

    @include('layouts.partials.navbar-guest')

    <header class="relative bg-cover bg-center h-[80vh] flex items-center justify-center pt-16" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop');">
        <div class="container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-6xl font-serif font-bold leading-tight mb-4">Your Perfect Stay Awaits</h1>
            <p class="text-xl md:text-2xl font-light mb-8">Discover and book exclusive rooms at unbeatable prices.</p>
            
        </div>
    </header>

    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl text-center font-serif mb-12">Our Featured Rooms</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $rooms = [
                        ['name' => 'Deluxe King Room', 'price' => '1.250.000', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=2070&auto=format&fit=crop'],
                        ['name' => 'Executive Ocean Suite', 'price' => '2.500.000', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2070&auto=format&fit=crop'],
                        ['name' => 'Standard Twin Room', 'price' => '850.000', 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=2070&auto=format&fit=crop']
                    ];
                @endphp
                @foreach ($rooms as $room)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-2 duration-300">
                    <img src="{{ $room['image'] }}" class="h-64 w-full object-cover" alt="{{ $room['name'] }}">
                    <div class="p-6 flex flex-col flex-grow">
                        <h5 class="text-xl font-medium text-gray-800">{{ $room['name'] }}</h5>
                        <div class="flex items-center my-2 text-amber-500">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="bi {{ $i < $room['rating'] ? 'bi-star-fill' : 'bi-star' }} mr-1"></i>
                            @endfor
                        </div>
                        <p class="text-gray-500 text-sm mb-4"><i class="bi bi-wifi mr-1"></i> Free Wifi <span class="mx-2">·</span> <i class="bi bi-cup-straw mr-1"></i> Breakfast</p>
                        <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                            <p class="text-lg font-semibold text-teal-800">IDR {{ $room['price'] }}<small class="font-normal text-gray-500">/night</small></p>
                            <a href="{{ route('login') }}" class="px-4 py-2 border border-teal-700 text-teal-700 rounded-md hover:bg-teal-700 hover:text-white transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('layouts.partials.footer-guest')

</body>
</html>