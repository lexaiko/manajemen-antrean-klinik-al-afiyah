@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <section class="jumbotron w-full h-3/4 md:h-screen">
        <div class="relative w-full h-3/4 overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt="">
            <div
                class="absolute inset-0 flex flex-col justify-center items-start bg-black/30 bg-opacity-30 text-white text-left pl-[300px]">
                <h1 class="text-2xl md:text-4xl font-bold mb-2">Selamat Datang</h1>
                <p class="text-sm md:text-lg mb-3">di Klinik Al Afiyah Blimbingsari</p>
            </div>

        </div>
        <div class=" relative z-10 flex justify-center items-center  ">
            <div class="flex justify-center items-center p-2 bg-white shadow rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5 ">
                <div class=" w-full sm:w-3/4 lg:w-1/2">
                    <h1 class="flex text-2xl justify-center font-bold">
                        Pendaftaran Antrian
                    </h1>

                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            Nama Lengkap
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            Nomor Whatsapp
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            Umur
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            Keluhan
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@include('partials.footer')