<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Halent Parfum')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900 antialiased">

    <div class="min-h-screen flex flex-col justify-between">
        {{-- Navbar --}}
        @include('components.navbar')

        {{-- FLASH MESSAGE NOTIFIKASI --}}
        @if(session('success'))
            <div class="bg-emerald-600 text-white text-center py-2.5 text-xs font-semibold shadow-inner transition-all duration-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Konten Utama --}}
        <main class="flex-grow min-h-[70vh]">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.footer')
    </div>

</body>
</html>