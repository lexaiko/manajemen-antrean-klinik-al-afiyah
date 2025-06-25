@extends('layouts.main')

@section('content')
    <section class="jumbotron w-full" style="height: 33vh; min-height: 180px;">
        <div class="relative w-full h-full overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt="" style="height: 100%; object-fit: cover;">
        </div>
    </section>
        <div class="relative z-10 flex justify-center items-center w-full">
            <div
                class="flex flex-col justify-center items-center p-4 bg-white shadow-lg rounded-lg -mt-8 mb-5 w-[95%] max-w-4xl">
                <div class="w-full">
                    {{-- ...existing code... --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                        <form method="GET" action="{{ route('antrean.index') }}"
                            class="flex items-center gap-2 w-full md:w-auto">
                            <label for="filter" class="block text-sm font-medium text-gray-700 mr-2">Filter Poli:</label>
                            <select id="filter" name="filter" onchange="this.form.submit()"
                                class="form-select block w-full md:w-48 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm">
                                <option value="">Semua Poli</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}"
                                        {{ request('filter') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    {{-- ...existing code... --}}
                    <div class="flex justify-center items-center">
                        <h1 class="py-3 text-base md:text-lg font-semibold text-gray-700">
                            {{ $todayFormatted }}
                        </h1>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-lg">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-center">Inisial</th>
                                    <th scope="col" class="px-4 py-3 text-center">Nomor Antrean</th>
                                    <th scope="col" class="px-4 py-3 text-center">Poli Tujuan</th>
                                    <th scope="col" class="px-4 py-3 text-center">Status Antrean</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($antrian as $antri)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-center align-middle p-2">
                                            {{ $antri->inisial_nama ?? '-' }}
                                        </td>
                                        <td class="text-center align-middle p-2">
                                            {{ $antri->nomor_antrian }}
                                        </td>
                                        <td class="text-center align-middle p-2">
                                            Poli {{ $antri->polis->nama_poli ?? '-' }}
                                        </td>
                                        <td class="text-center align-middle p-2">
                                            {{ $antri->status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500 py-4">
                                            Belum ada antrean hari ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
