<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klinik Al-Afiyah</title>
    {{-- logo pavicon --}}
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $today = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
    @endphp

    <script>
        function updateJam() {
            const now = new Date();
            const jam = now.toLocaleTimeString('id-ID', {
                hour12: false
            });
            document.getElementById('jam').textContent = jam;
        }

        setInterval(updateJam, 1000); // per detik
        updateJam(); // panggil pertama kali
    </script>

    <nav class="font-bold shadow-sm">

        <div class="flex items-center justify-between w-full px-4 py-2">
            <!-- Kiri -->
            <div class="flex-none">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ url('images/logo.png') }}" class="w-12 h-12" alt="Logo">
                </a>
            </div>

            <!-- Tengah -->
            <div class="flex-1 text-center">
                <span id="jam" class="font-bold"></span>
            </div>

            <!-- Kanan -->
            <div class="flex-none text-right">
                {{ $today }}
            </div>
        </div>
    </nav>
    <div class="">
        <div class="flex flex-wrap -mx-4">
            <iframe class="border rounded-lg" width="760" height="415"
                src="https://www.youtube.com/embed/2EuwcZVEmSk" frameborder="0" allowfullscreen></iframe>
        </div>
        
    </div>

</body>
