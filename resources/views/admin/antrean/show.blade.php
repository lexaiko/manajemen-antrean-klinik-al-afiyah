<x-app-layout>
    <x-layout>
        @if (session()->has('success'))
            <div id="alert-2"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="/admin/antrean"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Antrean</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center mb-4">
            <h1 class="py-2 text-xl font-bold text-gray-900 dark:text-white">Detail Antrean</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Data Pasien</h2>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">NIK Pasien</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->nik_pasien }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Nama Pasien</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->nama_pasien }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Alamat</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->alamat_pasien }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Jenis Kelamin</dt>
                        <dd class="text-gray-900 dark:text-white">
                            {{ $antrean->jenis_kelamin === 'L' ? 'Laki-laki' : ($antrean->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Tanggal Lahir</dt>
                        <dd class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($antrean->tanggal_lahir)->format('d M Y') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Nomor WhatsApp</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->nomor_whatsapp }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Detail Antrean</h2>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Tanggal Kunjungan</dt>
                        <dd class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($antrean->tanggal_kunjungan)->format('d M Y') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Nomor Antrian</dt>
                        <dd class="text-blue-600 dark:text-blue-400 font-bold text-lg">{{ $antrean->nomor_antrian }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Status</dt>
                        <dd>
                            @php
                                $statusColor = [
                                    'menunggu' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'diproses' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'selesai' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'batal' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor[$antrean->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ ucfirst($antrean->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Pembayaran</dt>
                        <dd class="text-gray-900 dark:text-white">{{ ucfirst($antrean->pembayaran) }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Poli</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->polis->nama_poli ?? '-' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Keluhan</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $antrean->keluhan }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </x-layout>
</x-app-layout>
