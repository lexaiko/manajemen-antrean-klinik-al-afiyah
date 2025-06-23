<x-app-layout>
    <x-layout>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/admin/antrean"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Antrean
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="/admin/antrean/create"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Daftar
                            Antrean</a>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="mb-4 py-2 text-3xl font-bold text-gray-900 dark:text-white ">Daftar Antrean</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- Tampilkan pesan error jika ada -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                role="alert">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.antrian.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-2 sm:grid-cols-2 sm:gap-2">
                <div>
                    @php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                    @endphp
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        tanggal kunjungan
                    </label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" min="{{ $today }}"
                        placeholder="Pilih tanggal kunjungan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('tanggal_kunjungan') is-invalid @enderror"
                        value="{{ old('tanggal_kunjungan') }}" required>
                    @error('tanggal_kunjungan')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nik" class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
                    <input type="number" name="nik_pasien" id="nik" pattern="[0-9]{16}"
                        placeholder="Masukkan NIK"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}" required>
                    @error('nik')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama
                        Pasien</label>
                    <input type="text" name="nama_pasien" id="nama" placeholder="Masukkan nama pasien"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat
                        Pasien</label>
                    <input type="text" name="alamat_pasien" id="alamat" placeholder="Masukkan alamat pasien"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat') }}" required>
                    @error('alamat')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jeniskelamin" class="block mb-2 text-sm font-medium text-gray-900">Jenis
                        Kelamin</label>
                    <select id="jeniskelamin" name="jenis_kelamin"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('jeniskelamin') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jeniskelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ old('jeniskelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    @php
                        $kemarin = \Carbon\Carbon::yesterday()->format('Y-m-d');
                    @endphp
                    <label for="tanggallahir" class="block mb-2 text-sm font-medium text-gray-900">
                        Tanggal Lahir
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggallahir" max="{{ $kemarin }}"
                        placeholder="Pilih tanggal lahir"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('tanggallahir') is-invalid @enderror"
                        value="{{ old('tanggallahir') }}" required>
                    @error('tanggallahir')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <select id="status" name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('status') is-invalid @enderror">
                        <option value="antri" {{ old('status') == 'antri' ? 'selected' : '' }}>Antri</option>
                        <option value="ditangguhkan" {{ old('status') == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                        <option value="dilayani" {{ old('status') == 'dilayani' ? 'selected' : '' }}>Sedang Dilayani</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="pembayaran" class="block mb-2 text-sm font-medium text-gray-900">Pembayaran</label>
                    <select id="pembayaran" name="pembayaran"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('pembayaran') is-invalid @enderror">
                        <option value="umum" {{ old('pembayaran') == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="bpjs" {{ old('pembayaran') == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                        <option value="mwcnu" {{ old('pembayaran') == 'mwcnu' ? 'selected' : '' }}>MWC NU</option>
                    </select>
                    @error('pembayaran')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" placeholder="Masukkan keluhan pasien"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('keluhan') is-invalid @enderror"
                        required>{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nomor_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">Nomor
                        Whatsapp</label>
                    <input type="tel" name="nomor_whatsapp" id="nomor_whatsapp"
                        placeholder="Masukkan nomor WhatsApp"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nomor_whatsapp') is-invalid @enderror"
                        value="{{ old('nomor_whatsapp') }}" required>
                    @error('nomor_whatsapp')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="poli" class="block mb-2 text-sm font-medium text-gray-900">Poli
                        Tujuan</label>
                    <select id="poli" name="polis_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error('poli') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Poli Tujuan</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}">
                                Poli - {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                    @error('poli')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-green-200 hover:bg-green-700 mb-5">
                    Daftar
                </button>
            </div>
        </form>
    </x-layout>
</x-app-layout>
