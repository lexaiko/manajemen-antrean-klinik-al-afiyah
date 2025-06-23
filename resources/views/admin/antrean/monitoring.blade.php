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
        \Carbon\Carbon::setLocale('id');
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
    <div class="flex flex-row">
        <div class="flex flex-col w-3/5">
            <div
                class='w-full max-w-[730px] p-2 bg-green-600 mx-5 mt-5 rounded-lg mb-5 flex flex-row justify-center outline outline-2 outline-gray-300'>
                <div class='flex justify-center items-center flex-col mx-10'>
                    <h1 class='font-bold text-lg text-white'>
                        Sedang Dilayani
                    </h1>
                    <div class='border-t border-white w-full mt-2'>
                    </div>
                    <h1 class='font-bold text-lg text-white'>
                        Poli Umum
                    </h1>
                    <h1 class='text-3xl font-bold my-10 text-white '>
                        {{ $dilayani_du->nomor_antrian ?? 'Selesai' }}
                    </h1>
                </div>
                <div class='flex justify-center items-center flex-col mx-10'>
                    <h1 class='font-bold text-lg text-white'>
                        Sedang Dilayani
                    </h1>
                    <div class='border-t border-white w-full mt-2 '>
                    </div>                    
                    <h1 class='font-bold text-lg text-white'>
                        Poli Gigi
                    </h1>
                    <h1 class='text-3xl font-bold my-10 text-white '>
                        {{ $dilayani_dg->nomor_antrian ?? 'Selesai' }}
                    </h1>
                </div>
                <div class='flex justify-center items-center flex-col mx-10'>
                    <h1 class='font-bold text-lg text-white'>
                        Sedang Dilayani
                    </h1>
                    <div class='border-t border-white w-full mt-2 '>
                    </div>                    
                    <h1 class='font-bold text-lg text-white'>
                        Poli KIA
                    </h1>
                    <h1 class='text-3xl font-bold my-10 text-white '>
                        {{ $dilayani_kia->nomor_antrian ?? 'Selesai' }}
                    </h1>
                </div>
                
            </div>

            <div class="flex flex-wrap rounded-lg mx-5 aspect-video">
                <iframe class="border rounded-lg" width="760" height="415"
                    src="https://www.youtube.com/embed/2EuwcZVEmSk" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="flex flex-col w-2/6">
            <div class="flex flex-col w-full ">
                <p class="mx-6 font-bold text-green-600 mt-5 text-lg">Poli Umum</p>
                <div
                    class='w-full h-[150px] p-2 my-3 bg-green-600 mx-5 rounded-lg  flex flex-col items-center outline outline-2 outline-gray-300'>
                    <p class="text-lg font-bold text-white">Nomor Antrean Selanjutnya</p>
                    <div class='border-t border-white w-4/5 my-1'>
                    </div>
                    <p class="text-3xl font-bold text-white my-9">{{ $duberikutnya->nomor_antrian ?? "Selesai" }}</p>
                </div>
            </div>
            <div class="flex flex-col w-full ">
                <p class="mx-6 font-bold text-green-600 text-lg">Poli Gigi</p>
                <div
                    class='w-full h-[150px] p-2 my-3 bg-green-600 mx-5 rounded-lg  flex flex-col items-center outline outline-2 outline-gray-300'>
                    <p class="text-lg font-bold text-white">Nomor Antrean Selanjutnya</p>
                    <div class='border-t border-white w-4/5 my-1'>
                    </div>
                    <p class="text-3xl font-bold text-white my-9">{{ $dgberikutnya->nomor_antrian ?? "Selesai" }}</p>
                </div>
            </div>
            <div class="flex flex-col w-full ">
                <p class="mx-6 font-bold text-green-600  text-lg">Poli KIA</p>
                <div
                    class='w-full h-[150px] p-2 my-3 bg-green-600 mx-5 rounded-lg  flex flex-col items-center outline outline-2 outline-gray-300'>
                    <p class="text-lg font-bold text-white">Nomor Antrean Selanjutnya</p>
                    <div class='border-t border-white w-4/5 my-1'>
                    </div>
                    <p class="text-3xl font-bold text-white my-9">{{ $kiaberikutnya->nomor_antrian ?? "Selesai" }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
