<x-app-layout>
    <x-layout>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Kontrol Antrian Klinik</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($polis as $poli)
            @php
                $dilayani = $poli->antrians->firstWhere('status', 'dilayani');
                $selanjutnya = $poli->antrians->firstWhere('status', 'antri');
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 space-y-4 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $poli->nama_poli }}</h2>

                <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded text-center">
                    <p class="text-sm text-blue-800 dark:text-blue-200">Sedang Dilayani</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-white">
                        {{ $dilayani->nomor_antrian ?? '-' }}
                    </p>
                </div>

                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded text-center">
                    <p class="text-sm text-gray-700 dark:text-gray-300">Selanjutnya</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $selanjutnya->nomor_antrian ?? 'Tidak Ada' }}
                    </p>
                </div>

                <form action="{{ route('admin.antrean.control.next', $poli->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        Lanjutkan ke Pasien Berikutnya
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
</x-layout>
</x-app-layout>
