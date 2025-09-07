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
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.laporan.antrean') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Laporan
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Laporan Antrean</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex justify-between items-center mb-4">
            <h1 class="py-2 text-xl font-bold text-gray-900 dark:text-white">Laporan Antrean</h1>
        </div>

        <!-- Statistik Cards -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex-1 min-w-[180px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-600">Total</p>
                        <p class="text-lg font-semibold text-blue-900">{{ $statistik['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 flex-1 min-w-[180px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-600">Antri</p>
                        <p class="text-lg font-semibold text-yellow-900">{{ $statistik['antri'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex-1 min-w-[180px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-600">Dilayani</p>
                        <p class="text-lg font-semibold text-blue-900">{{ $statistik['dilayani'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex-1 min-w-[180px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-600">Selesai</p>
                        <p class="text-lg font-semibold text-green-900">{{ $statistik['selesai'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex-1 min-w-[180px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-600">Ditangguhkan</p>
                        <p class="text-lg font-semibold text-red-900">{{ $statistik['ditangguhkan'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.laporan.antrean') }}" id="filterForm"
                    class="flex flex-col gap-4">
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[150px]">
                            <label for="tanggal_mulai" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ request('tanggal_mulai') }}"
                                class="block w-full rounded border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="flex-1 min-w-[150px]">
                            <label for="tanggal_akhir" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Akhir</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                                class="block w-full rounded border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="flex-1 min-w-[120px]">
                            <label for="status" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select id="status" name="status"
                                class="block w-full rounded border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Semua Status</option>
                                <option value="antri" {{ request('status') == 'antri' ? 'selected' : '' }}>Antri</option>
                                <option value="dilayani" {{ request('status') == 'dilayani' ? 'selected' : '' }}>Dilayani</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditangguhkan" {{ request('status') == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                            </select>
                        </div>

                        <div class="flex-1 min-w-[120px]">
                            <label for="poli_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Poli</label>
                            <select id="poli_id" name="poli_id"
                                class="block w-full rounded border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Semua Poli</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>
                            <button type="button" onclick="downloadLaporan()"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:focus:ring-green-800 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Tanggal Kunjungan</th>
                            <th scope="col" class="px-4 py-3">No. Antrian</th>
                            <th scope="col" class="px-4 py-3">Nama Pasien</th>
                            <th scope="col" class="px-4 py-3">Poli Tujuan</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Pembayaran</th>
                            <th scope="col" class="px-4 py-3">Keluhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antrian as $item)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ ($antrian->currentPage() - 1) * $antrian->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>
                                <td class="px-4 py-3">{{ $item->nomor_antrian }}</td>
                                <td class="px-4 py-3">{{ $item->nama_pasien }}</td>
                                <td class="px-4 py-3">{{ $item->polis->nama_poli ?? 'Tidak Diketahui' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $item->status === 'antri' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $item->status === 'dilayani' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $item->status === 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $item->status === 'ditangguhkan' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ ucfirst($item->pembayaran) }}</td>
                                <td class="px-4 py-3">{{ Str::limit($item->keluhan, 50) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Tidak ada data laporan antrean.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-600 dark:text-gray-400">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">
                        @if ($antrian->count())
                            {{ $antrian->firstItem() }}-{{ $antrian->lastItem() }}
                        @else
                            0-0
                        @endif
                    </span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $antrian->total() }}</span>
                </span>
                <div>
                    {{ $antrian->links() }}
                </div>
            </nav>
        </div>

        <script>
            function downloadLaporan() {
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);

                // Create a temporary link and click it to download
                const pdfUrl = "{{ route('admin.laporan.antrean.pdf') }}" + '?' + params.toString();
                const link = document.createElement('a');
                link.href = pdfUrl;
                link.download = 'laporan-antrean-' + new Date().getTime() + '.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            function cetakPDF() {
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);

                const pdfUrl = "{{ route('admin.laporan.antrean.pdf') }}" + '?' + params.toString();
                window.open(pdfUrl, '_blank');
            }
        </script>
    </x-layout>
</x-app-layout>
