<x-app-layout>
    <x-layout>
        <x-slot:title>Dashboard</x-slot:title>

        <div class="max-w-7xl mx-auto py-10 px-4">
            <h1 class="text-xl font-bold mb-8">Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 col-span-1 md:col-span-3">
                    <div class="text-gray-500 dark:text-gray-300">Anda masuk sebagai {{ Auth::user()->name }} dengan role
                    {{ Auth::user()->getRoleNames()->first() ?? '-' }}!</div>
                </div>
                {{-- Total User --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <div class="text-gray-500 dark:text-gray-300">Total Pegawai</div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalUser }} Pegawai</div>
                </div>

                {{-- Total Berita --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <div class="text-gray-500 dark:text-gray-300">Total Berita</div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalBerita }} Berita</div>
                </div>
                {{-- Total Produk --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <div class="text-gray-500 dark:text-gray-300">Total Pasien Hari ini</div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalAntrianHariIni }} Pasien</div>
                </div>
            </div>
        </div>
    </x-layout>
</x-app-layout>
