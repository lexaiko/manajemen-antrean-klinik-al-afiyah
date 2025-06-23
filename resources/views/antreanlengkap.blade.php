@extends('layouts.main')

@include('partials.navbar')
@section('content')
    <section class="jumbotron w-full h-3/4 md:h-screen">
        <div class="relative w-full h-3/4 overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt="">
            <div
                class="absolute inset-0 flex flex-col justify-center items-start bg-black/30 bg-opacity-30 text-white text-left pl-[100px] lg:pl-[300px] ">
                <h1 class="text-2xl md:text-4xl font-bold mb-2">Selamat Datang</h1>
                <p class="text-sm md:text-lg mb-3">di Klinik Al Afiyah Blimbingsari</p>
            </div>
        </div>
        @php
            \Carbon\Carbon::setLocale('id');
            $today = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
            $day = \Carbon\Carbon::now()->format('Y-m-d');
            $adaAntrean = false;

        @endphp
        <div class=" relative z-10 flex justify-center items-center">
            <div
                class="flex justify-center items-center p-2 bg-white shadow rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5 ">
                <div class="overflow-x-auto">
                    <div class="flex justify-center items-center">
                        <h1 class="py-5">
                            {{ $today }}
                        </h1>
                    </div>
                    <form method="GET" action="{{ route('monitoringlengkap') }}" class="mb-4 flex justify-start ">
                        <select name="filter" onchange="this.form.submit()"
                            class="border rounded-lg w-2/5">
                            <option value="">Semua Poli</option>
                            <option value="poli_umum" {{ request('filter') == 'poli_umum' ? 'selected' : '' }}>Poli
                                Umum</option>
                            <option value="poli_gigi" {{ request('filter') == 'poli_gigi' ? 'selected' : '' }}>Poli
                                Gigi</option>
                                <option value="poli_kia" {{ request('filter') == 'poli_kia' ? 'selected' : '' }}>Poli
                                KIA</option>
                        </select>
                    </form>


                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-lg">
                            <tr>
                                <th scope="col" class="px-10 py-3">
                                    Inisial
                                </th>
                                <th scope="col" class="px-10 py-3">
                                    Nomor Antrean
                                </th>
                                <th scope="col" class="px-10 py-3">
                                    Poli Tujuan
                                </th>
                                <th scope="col" class="px-10 py-3">
                                    Status Antrean
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($antrian as $antri)
                                @if ($antri->tanggal_kunjungan === $day)
                                    @php $adaAntrean = true; @endphp
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="text-center align-middle p-2">
                                            @php
                                                $nama = $antri->nama_pasien;
                                                $kata = explode(' ', $nama);
                                                $inisial = '';
                                                for ($i = 0; $i < min(3, count($kata)); $i++) {
                                                    $inisial .= substr($kata[$i], 0, 2);
                                                }
                                            @endphp
                                            {{ $inisial }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $antri->nomor_antrian }}
                                        </td>
                                        <td class="text-center align-middle">
                                            Poli {{ $antri->polis->nama_poli ?? '-' }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $antri->status }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if (!$adaAntrean)
                                <tr class="border-b dark:border-gray-700">
                                    <td colspan="4" class="text-center text-gray-500 py-4">
                                        Belum ada antrean hari ini
                                    </td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('partials.footer')
