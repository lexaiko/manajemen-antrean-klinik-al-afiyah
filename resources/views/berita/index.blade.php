@extends('layouts.main')

@section('content')
    @include('partials.navbar')
<!-- Card Blog -->
<div class="max-w-[85rem] px-4 py-5 sm:px-6 lg:px-8 lg:py-14 mx-auto mt-16 sm:mt-12">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
      <h2 class="text-2xl font-bold md:text3xl md:leading-tight dark:text-white">Berita Klinik Al Afiyah Banyuwangi</h2>
      <p class="mt-1 text-gray-600 dark:text-neutral-400">Informasi terbaru seputar klinik Al Afiyah Banyuwangi</p>
    </div>
    <!-- End Title -->

    <!-- Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Card -->
      @foreach ($beritas as $berita)
      <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Berita Image" class="w-full h-56 object-cover">
                        <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            {{ \Carbon\Carbon::parse($berita->tgl_published)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">{{ $berita->judul }}</h3>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5 dark:text-gray-600">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="self-center text-sm text-gray-700">Oleh - {{ $berita->nama_published }}</span>
                        </div>
                        <a href="{{ route('berita.detail', $berita->slug) }}" class="mt-auto inline-block text-green-600 hover:underline font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
      @endforeach
    </div>
    <!-- End Card -->
  </div>
  <!-- End Card Blog -->
@endsection
