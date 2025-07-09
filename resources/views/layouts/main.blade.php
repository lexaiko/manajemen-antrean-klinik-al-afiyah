<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Klinik Al-Afiyah</title>

    {{-- logo pavicon --}}
   <link rel="icon" href="/favicon.ico" type="image/x-icon">

<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen flex flex-col">
    {{-- Navbar --}}
    @if (!isset($hideNavbar))
    @include('partials.navbar')
@endif


    {{-- Konten utama --}}
    <main class="flex-1">
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        @yield('content')
    </main>

    {{-- Footer selalu di bawah --}}
    @include('partials.footer')

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    AOS.init();
  });
</script>
</body>


</html>
