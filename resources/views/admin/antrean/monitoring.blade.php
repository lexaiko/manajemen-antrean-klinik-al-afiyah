<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klinik Al-Afiyah</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <!-- Tailwind & Flowbite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 min-h-screen">
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
        setInterval(updateJam, 1000);
        updateJam();
    </script>

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <img src="{{ url('images/logo.png') }}" class="w-10 h-10" alt="Logo">
                <span class="font-bold text-green-700 text-lg hidden sm:inline">Klinik Al-Afiyah</span>
            </a>
            <!-- Jam -->
            <span id="jam" class="font-mono text-xl font-semibold text-gray-700"></span>
            <!-- Tanggal -->
            <span class="text-gray-600 font-medium">{{ $today }}</span>
            <button id="fullscreen-btn" type="button" class="ml-4 px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700 transition">
    Fullscreen
</button>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sedang Dilayani & Video -->
            <div class="lg:col-span-2 space-y-6">
                <div id="monitoring-antrian" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($polis as $poli)
                        @php
                            $sedangDilayani = $poli->antrians->firstWhere('status', 'dilayani');
                        @endphp
                        <div class="bg-green-600 rounded-lg shadow-lg p-6 flex flex-col items-center justify-center">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white font-semibold text-lg">Sedang Dilayani</span>
                            </div>
                            <span class="uppercase font-bold text-white text-base">{{ $poli->nama_poli }}</span>
                            <span class="text-4xl font-extrabold mt-3 text-white drop-shadow">
                                {{ $sedangDilayani->nomor_antrian ?? 'Selesai' }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <!-- Video YouTube -->
                <div class="rounded-lg overflow-hidden shadow-lg bg-white">
                    <iframe width="100%" height="450" src="https://www.youtube.com/embed/2EuwcZVEmSk"
                        title="Profil Klinik" frameborder="0" allowfullscreen class="w-full"></iframe>
                </div>
            </div>
            <!-- Antrian Selanjutnya -->
            <div id="monitoring-selanjutnya" class="space-y-4">
                <h2 class="text-lg font-bold text-green-700 mb-2">Antrian Selanjutnya</h2>
                @foreach ($polis as $poli)
                    @php
                        $selanjutnya = $poli->antrians->where('status', 'antri')->first();
                    @endphp
                    <div class="bg-white border border-green-200 rounded-lg shadow p-5 flex flex-col items-center">
                        <span class="text-green-700 font-semibold mb-1">Poli {{ $poli->nama_poli }}</span>
                        <hr class="w-1/2 border-green-300 my-2">
                        <span class="font-bold text-2xl text-gray-800">
                            {{ $selanjutnya->nomor_antrian ?? 'Selesai' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
    <script>
function renderSelanjutnya(polis) {
    let html = '<h2 class="text-lg font-bold text-green-700 mb-2">Antrian Selanjutnya</h2>';
    polis.forEach(function(poli) {
        let selanjutnya = poli.antrians.find(a => a.status === 'antri');
        html += `
        <div class="bg-white border border-green-200 rounded-lg shadow p-5 flex flex-col items-center">
            <span class="text-green-700 font-semibold mb-1">Poli ${poli.nama_poli}</span>
            <hr class="w-1/2 border-green-300 my-2">
            <span class="font-bold text-2xl text-gray-800">
                ${(selanjutnya && selanjutnya.nomor_antrian) ? selanjutnya.nomor_antrian : 'Selesai'}
            </span>
        </div>
        `;
    });
    document.getElementById('monitoring-selanjutnya').innerHTML = html;
}

function renderMonitoring(polis) {
    let html = '';
    polis.forEach(function(poli) {
        let sedangDilayani = poli.antrians.find(a => a.status === 'dilayani');
        html += `
        <div class="bg-green-600 rounded-lg shadow-lg p-6 flex flex-col items-center justify-center">
            <div class="flex items-center space-x-2 mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-white font-semibold text-lg">Sedang Dilayani</span>
            </div>
            <span class="uppercase font-bold text-white text-base">${poli.nama_poli}</span>
            <span class="text-4xl font-extrabold mt-3 text-white drop-shadow">
                ${(sedangDilayani && sedangDilayani.nomor_antrian) ? sedangDilayani.nomor_antrian : 'Selesai'}
            </span>
        </div>
        `;
    });
    document.getElementById('monitoring-antrian').innerHTML = html;
}

function fetchMonitoring() {
    fetch('{{ route('admin.antrean.monitoring.data') }}')
        .then(response => response.json())
        .then(data => {
            renderMonitoring(data.polis);
            renderSelanjutnya(data.polis);
        });
}

// Jalankan setiap 5 detik
setInterval(fetchMonitoring, 5000);
</script>
<script>
document.getElementById('fullscreen-btn').addEventListener('click', function() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
});
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>
