@extends('layouts.main')

@section('content')
    <section class="jumbotron h-1/3 md:h-1/3 w-full">
        <div class="relative w-full overflow-hidden" style="height: 33vh; min-height: 180px;">
            <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt=""
                style="height: 100%; object-fit: cover;">
        </div>
        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form action="{{ route('antrean.storeRegistrasi') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="relative z-10 flex justify-center items-center">
                <div
                    class="flex justify-center items-center p-2 bg-white shadow rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5">
                    <div class="w-full sm:w-3/4 lg:w-1/2">
                        <h1 class="flex text-2xl justify-center font-bold">
                            Pendaftaran Antrean
                        </h1>
                        <div class="flex flex-col sm:grid sm:grid-cols-2 sm:gap-x-4">
                            @php
                                $today = \Carbon\Carbon::now()->format('Y-m-d');
                                $kemarin = \Carbon\Carbon::yesterday()->format('Y-m-d');
                            @endphp

                            <div class="flex flex-col mt-5">
                                <label for="tanggal_kunjungan" class="mb-2">
                                    Tanggal Kunjungan
                                </label>
                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                                    min="{{ $today }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('tanggal_kunjungan') is-invalid @enderror"
                                    value="{{ old('tanggal_kunjungan') }}" required placeholder="Pilih tanggal kunjungan">
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="nik_pasien" class="mb-2">
                                    NIK Pasien
                                </label>
                                <input type="text" name="nik_pasien" id="nik_pasien" placeholder="Masukkan NIK pasien"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nik_pasien') is-invalid @enderror"
                                    value="{{ old('nik_pasien') }}" required>
                                @error('nik_pasien')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="nama_pasien" class="mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_pasien" id="nama_pasien"
                                    placeholder="Masukkan nama lengkap"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nama_pasien') is-invalid @enderror"
                                    value="{{ old('nama_pasien') }}" required>
                                @error('nama_pasien')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="alamat_pasien" class="mb-2">
                                    Alamat
                                </label>
                                <input type="text" name="alamat_pasien" id="alamat_pasien" placeholder="Masukkan alamat"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('alamat_pasien') is-invalid @enderror"
                                    value="{{ old('alamat_pasien') }}" required>
                                @error('alamat_pasien')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="nomor_whatsapp" class="mb-2">
                                    Nomor Whatsapp
                                </label>
                                <input type="tel" name="nomor_whatsapp" id="nomor_whatsapp"
                                    placeholder="Masukkan nomor Whatsapp"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nomor_whatsapp') is-invalid @enderror"
                                    value="{{ old('nomor_whatsapp') }}" required>
                                @error('nomor_whatsapp')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="tanggal_lahir" class="mb-2">
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" max="{{ $kemarin }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}" required placeholder="Pilih tanggal lahir">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="jenis_kelamin" class='mb-2 text-sm font-medium text-gray-900'>
                                    Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('jenis_kelamin') is-invalid @enderror'>
                                    <option value="" disabled selected>Pilih jenis kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-col mt-5">
                                <label for="pembayaran" class='mb-2 text-sm font-medium text-gray-900'>
                                    Pembayaran
                                </label>
                                <select name="pembayaran" id="pembayaran"
                                    class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('pembayaran') is-invalid @enderror'>
                                    <option value="" disabled selected>Pilih metode pembayaran</option>
                                    <option value="umum" {{ old('pembayaran') == 'umum' ? 'selected' : '' }}>Umum
                                    </option>
                                    <option value="bpjs" {{ old('pembayaran') == 'bpjs' ? 'selected' : '' }}>BPJS
                                    </option>
                                    <option value="mwcnu" {{ old('pembayaran') == 'mwcnu' ? 'selected' : '' }}>MWC NU
                                    </option>
                                </select>
                                @error('pembayaran')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex col-span-2 flex-col mt-5">
                                <label for="poli" class='mb-2 text-sm font-medium text-gray-900'>
                                    Poli Tujuan
                                </label>
                                <select id="poli" name="polis_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('poli') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih poli tujuan</option>
                                    @foreach ($polis as $poli)
                                        <option value="{{ $poli->id }}"
                                            {{ old('polis_id') == $poli->id ? 'selected' : '' }}>
                                            {{ $poli->nama_poli }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('poli')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-span-2 flex flex-col mt-5">
                                <label for="keluhan" class="mb-2">
                                    Keluhan
                                </label>
                                <textarea name="keluhan" id="keluhan" rows="3" placeholder="Masukkan keluhan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 resize-y @error('keluhan') is-invalid @enderror"
                                    required>{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-span-2 flex mt-5">
                                    <div class="cf-turnstile w-full" data-sitekey="0x4AAAAAABkhqYA8xDomwo8_"
                                        data-theme="light" data-size="flexible"></div>
                            </div>

                            @error('turnstile')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror

                            <div class="col-span-2 mt-6">
                                <button type="submit"
                                    class="w-full inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-green-200 hover:bg-green-700">
                                    <span class="flex justify-center items-center w-full">Daftar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection
