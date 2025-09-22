<x-app-layout>
    <x-layout>
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">Kontrol Antrian Klinik</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($polis as $poli)
                    @php
                        $dilayani = $poli->antrians->firstWhere('status', 'dilayani');
                        $selanjutnya = $poli->antrians->firstWhere('status', 'antri');
                        $skips = $poli->antrians->where('status', 'skip');
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
                        <form action="{{ route('admin.antrean.control.skip', $poli->id) }}" method="POST"
                            class="mt-2">
                            @csrf
                            <button type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                                Lewati Pasien Selanjutnya
                            </button>
                        </form>

                        <button type="button"
                            onclick="panggil('{{ $dilayani->nomor_antrian ?? '-' }}', '{{ $poli->nama_poli }}')"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mt-2">
                            Panggil Nomor
                        </button>

                        <script>
                            function panggil(nomor, poli) {
                                if (!nomor || nomor === '-') {
                                    alert("Tidak ada nomor antrean yang sedang dilayani.");
                                    return;
                                }

                                const text = `Nomor antrian ${nomor}, silakan menuju admin.`;

                                // Web Speech API
                                const utterance = new SpeechSynthesisUtterance(text);
                                utterance.lang = "id-ID"; // Bahasa Indonesia
                                utterance.rate = 0.9; // kecepatan bicara
                                utterance.pitch = 1; // nada suara
                                window.speechSynthesis.speak(utterance);
                            }
                        </script>
                        
                        @if ($skips->count())
                            <div class="mt-4 border-t pt-4">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Antrian Dilewati:</p>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border rounded-lg flowbite-table">
                                        <thead class="text-xs text-gray-700 uppercase bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200">
                                            <tr>
                                                <th scope="col" class="px-4 py-2">Nomor Antrian</th>
                                                <th scope="col" class="px-4 py-2">Nama Pasien</th>
                                                <th scope="col" class="px-4 py-2 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($skips as $skip)
                                                <tr class="bg-white dark:bg-yellow-950 border-b dark:border-yellow-900">
                                                    <td class="px-4 py-2 font-bold text-yellow-700 dark:text-yellow-300">
                                                        {{ $skip->nomor_antrian }}
                                                    </td>
                                                    <td class="px-4 py-2 text-gray-800 dark:text-yellow-100">
                                                        {{ $skip->nama_pasien }}
                                                    </td>
                                                    <td class="px-4 py-2 flex gap-2 justify-center">
                                                        <form action="{{ route('admin.antrean.control.restore', $skip->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition">
                                                                Antri
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.antrean.control.tangguhkan', $skip->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-xs rounded transition">
                                                                Ditangguhkan
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </x-layout>
</x-app-layout>
