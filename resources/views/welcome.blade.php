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
            <div
                class="flex justify-center items-center p-2 bg-white shadow rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5 ">

                <div class=" w-full sm:w-3/4 lg:w-1/2">
                    <h1 class="flex text-2xl justify-center font-bold">
                        Pendaftaran Antrian
                    </h1>
                    <div class='flex flex-col'>
                        @php
                            $today = \Carbon\Carbon::now()->format('Y-m-d');                            
                        @endphp
                        <h1 class="mt-5 mb-2">
                            Tanggal Kunjungan
                        </h1>
                        <input type="date" name="tanggal" id="tanggal" min="{{ $today }}" required>
                    </div>

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
                    <div class='flex flex-col'>
                        <h3 class="mt-5 mb-2">
                            Tanggal Lahir
                        </h3>
                        @php
                            $kemarin = \Carbon\Carbon::yesterday()->format('Y-m-d');
                        @endphp
                        <input type="date" name="tanggal" id="tanggal" max="{{ $kemarin }}" required>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            Keluhan
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label for="jenis_kelamin"
                            class='block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-5 mb-2'>
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('jenis_kelamin') is-invalid @enderror'>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            nik
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            nomor whatsapp
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="flex flex-col">
                        <h3 class="mt-5 mb-2">
                            alamat
                        </h3>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label for="jenis_kelamin"
                            class='block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-5 mb-2'>
                            pembayaran
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('jenis_kelamin') is-invalid @enderror'>
                            <option value="" disabled selected>Pilih Pembayaran</option>
                            <option value="L">umum</option>
                            <option value="P">BPJS</option>
                        </select>
                    </div>
                    <div class="">
                        <button type="submit"
                            class="w-full inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-700 hover:bg-amber-600">
                            <h3 class="flex justify-center items-center w-full ">Daftar</h3>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@include('partials.footer')