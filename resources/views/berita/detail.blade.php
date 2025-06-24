@extends('layouts.main')

@section('content')

    <section class="container mx-auto px-10 py-0 mt-16">
        <div class="flex justify-center py-5">
            <div
                class="bg-white text-left p-5 rounded-lg  max-w-3xl">
                <!-- Breadcrumb -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-3 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('berita.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors duration-300">
                                Berita
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="#"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white transition-colors duration-300">
                                    {{ $berita->judul }}</a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Title -->
                <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3">{{ $berita->judul }}</h3>

                <!-- Publish Date -->
                <p class="mb-3 text-gray-500">
                    {{ \Carbon\Carbon::parse($berita->tgl_published)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>

                <!-- Image with hover animation -->
                <div
                    class="card bg-white overflow-hidden rounded-lg">
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                        class="img-fluid rounded-4 w-full h-[629px] object-cover">
                </div>


                <div class="c-blog-detail-body py-3">
                    <p class="font-serif">
                        {!! $berita->konten !!}
                    </p>
                </div>

                <!-- Author Section with icon -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="w-5 h-5 dark:text-gray-600">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="self-center text-sm text-gray-700">Oleh - {{ $berita->nama_published }}</span>
                </div>
            </div>
        </div>
    </section>
    {{-- <script>
        $('#description').summernote({
            placeholder: 'description...',
            tabsize:2,
            height:300
        });
    </script> --}}
@endsection
