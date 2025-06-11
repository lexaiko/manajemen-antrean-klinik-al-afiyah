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
        <form action="{{ route('admin.antrian.store') }}" method="post" enctype="multipart/form-data">
            @csrf

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
                            <label for="tanggalkunjungan" class="mt-5 mb-2">
                                Tanggal Kunjungan
                            </label>
                            <input type="date" name="tanggal_kunjungan" id="tanggalkunjungan" min="{{ $today }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('tanggalkunjungan') is-invalid @enderror"
                                value="{{ old('tanggalkunjungan') }}" required>
                            @error('tanggalkunjungan')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="nik" class="mt-5 mb-2">
                                nik
                            </label>
                            <input type="text" name="nik" id="nik" placeholder="Masukkan Nama lengkap"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}" required>
                            @error('nik')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="nama" class="mt-5 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" name="nama_pasien" id="nama" placeholder="Masukkan Nama lengkap"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="alamat" class="mt-5 mb-2">
                                alamat
                            </label>
                            <input type="text" name="alamat_pasien" id="alamat" placeholder="Masukkan Alamat"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat') }}" required>
                            @error('alamat')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="nowa" class="mt-5 mb-2">
                                Nomor Whatsapp
                            </label>
                            <input type="tel" name="nomor_whatsapp" id="nowa" placeholder="Masukkan Nama lengkap"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('nowa') is-invalid @enderror"
                                value="{{ old('nowa') }}" required>
                            @error('nowa')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class='flex flex-col'>
                            <label for="tanggallahir" class="mt-5 mb-2">
                                Tanggal Lahir
                            </label>
                            @php
                                $kemarin = \Carbon\Carbon::yesterday()->format('Y-m-d');
                            @endphp
                            <input type="date" name="tanggal_lahir" id="tanggallahir" max="{{ $kemarin }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('tanggallahir') is-invalid @enderror"
                                value="{{ old('tanggallahir') }}" required>
                            @error('tanggallahir')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="keluhan" class="mt-5 mb-2">
                                Keluhan
                            </label>
                            <input type="text" name="keluhan" id="keluhan" placeholder="Masukkan Keluhan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('keluhan') is-invalid @enderror"
                                value="{{ old('keluhan') }}" required>
                            @error('keluhan')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
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
                            @error('jenis_kelamin')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="pembayaran"
                                class='block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-5 mb-2'>
                                pembayaran
                            </label>
                            <select name="pembayaran" id="pembayaran"
                                class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('pembayaran') is-invalid @enderror'>
                                <option value="umum" {{ old('pembayaran') == '1' ? 'selected' : '' }}>umum</option>
                                <option value="bpjs" {{ old('pembayaran') == '2' ? 'selected' : '' }}>BPJS</option>
                            </select>
                            @error('pembayaran')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="users"
                                class='block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-5 mb-2'>
                                Dokter Tujuan
                            </label>
                            <select name="pegawais_id" id="users"
                                class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('users') is-invalid @enderror'>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} - {{ $user->role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('users')
                                <div class="invalid-feedback text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <button type="submit"
                                class="w-full inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-700 hover:bg-amber-600">
                                <label class="flex justify-center items-center w-full ">Daftar</label>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection

@include('partials.footer')