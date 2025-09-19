<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Aura Bening Resort'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Lato', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div id="app" class="flex flex-col min-h-screen">

        {{-- ✨ Memanggil partial header --}}
        @include('partials.navbar') {{-- Kita tetap gunakan nama lama agar tidak merusak --}}

        {{-- Konten Utama Halaman --}}
        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- ✨ Memanggil partial footer --}}
        @include('partials.footer') {{-- Kita tetap gunakan nama lama agar tidak merusak --}}

    </div>

    @stack('scripts')
</body>
</html>