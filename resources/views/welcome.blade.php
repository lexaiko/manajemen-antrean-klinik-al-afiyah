@extends('layouts.main')

@include('partials.navbar')

@section('content')
   <section class="jumbotron w-full h-3/4 md:h-screen">
    <div class="relative w-full h-3/4 overflow-hidden">
        <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt="">
        <div
            class="absolute inset-0 flex flex-col justify-center items-start bg-black/30 bg-opacity-30 text-white text-left pl-[300px]">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang</h1>
                        <p class="text-lg md:text-xl mb-6">di Klinik Al Afiyah Blimbingsari</p>
                        <button type="button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-700">Daftar Antrean</button>
                    </div>
    </div>
   </section>
@endsection

@include('partials.footer')
