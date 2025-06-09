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

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- Tampilkan pesan error jika ada -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
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
                <div class=''>
                    @php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');                            
                    @endphp
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        tanggal kunjungan
                    </label>
                    <input type="date" name="tanggal" id="tanggal" min="{{ $today }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                </div>
                <div class="">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Pasien</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat
                        Pasien</label>
                    <input type="email" name="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jenis_kelamin"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('jenis_kelamin') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class=''>
                    @php
                        $kemarin = \Carbon\Carbon::yesterday()->format('Y-m-d');                            
                    @endphp
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tanggal Lahir
                    </label>
                    <input type="date" name="tanggal" id="tanggal" max="{{ $kemarin }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                </div>
                <div>
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" name="status_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('role') is-invalid @enderror">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Antri</option>
                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Ditangguhkan</option>
                        <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Sedang Dilayani</option>
                        <option value="4" {{ old('status') == '4' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="pembayaran"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pembayaran</label>
                    <select id="pembayaran" name="pembayaran_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('role') is-invalid @enderror">
                        <option value="1" {{ old('pembayaran') == '1' ? 'selected' : '' }}>umum</option>
                        <option value="2" {{ old('pembayaran') == '2' ? 'selected' : '' }}>BPJS</option>
                    </select>
                    @error('pembayaran')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                        Whatsapp</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keluhan</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <select name="dokter_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} - {{ $user->role->nama_role }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 text-sm font-medium text-center text-white bg-amber-500 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-700 hover:bg-amber-600 mb-5">
                    Daftar
                </button>
            </div>
        </form>
    </x-layout>
</x-app-layout>