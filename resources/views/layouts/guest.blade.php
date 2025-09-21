<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-gray-100">
            <div class="hidden lg:block relative w-0 lg:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop');">
                <div class="absolute inset-0 bg-black opacity-40"></div>
                <div class="relative z-10 flex flex-col justify-end h-full p-12 text-white">
                    <h2 class="text-4xl font-bold font-serif leading-tight">Your Perfect Stay, Just a Click Away.</h2>
                    <p class="mt-4 text-lg text-gray-200">Discover and book exclusive rooms with unparalleled comfort and service.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{-- Konten dari login/register akan dimuat di sini --}}
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>