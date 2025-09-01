<x-app-layout>
    <x-layout>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/admin/jadwal"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Jadwal Pegawai
                    </a>
                </li>
            </ol>
        </nav>
        <h2 class="text-2xl font-bold mb-6">
                Jadwal {{ $roleFilter ? ucfirst($roleFilter) : 'Semua Jadwal' }}
            </h2>
        <div class="max-w-6xl mx-auto py-3 px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                {{-- Filter Role --}}
                <form method="GET" action="{{ route('admin.jadwal.index') }}" class="w-full md:w-auto max-w-md">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Filter Jadwal
                    </label>
                    <div class="relative">
                        <select id="role" name="role" onchange="this.form.submit()"
                            class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
            focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600
            dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Semua Jadwal</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $roleFilter == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </form>


                @role('admin klinik')
                    {{-- Tombol Tambah Jadwal --}}
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a href="{{ route('admin.jadwal.create') }}"
                            class="flex items-center justify-center text-white bg-green-600 hover:bg-green-600 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Jadwal
                        </a>
                    </div>
                @endrole
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden space-y-6">
                @if ($jadwals->isEmpty())
                    <div
                        class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-md dark:bg-gray-800 dark:border-yellow-600 dark:text-yellow-300">
                        <p>⚠️ Tidak ada jadwal ditemukan untuk role ini.</p>
                    </div>
                @else
                    @foreach ($urutanHari as $hari)
                        @php
                            $jadwalHari = $jadwals->where('hari', $hari);
                        @endphp

                        <div>
                            <h2 class="text-lg font-bold text-blue-600 mb-2">🗓️ {{ $hari }}</h2>

                            @if ($jadwalHari->isNotEmpty())
                                @foreach ($jadwalHari as $jadwal)
                                    <div
                                        class="bg-white border border-gray-200 rounded-lg shadow p-4 mb-3 dark:bg-gray-800 dark:border-gray-700">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            👨‍⚕️ {{ $jadwal->pegawai->name }}
                                            ({{ $jadwal->pegawai->getRoleNames()->first() ?? '-' }})
                                        </div>

                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            ⏰ {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow p-4 mb-3 dark:bg-gray-800 dark:border-gray-700">
                                    <p class="text-gray-500 dark:text-gray-300">Tidak ada jadwal untuk hari ini.</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>



            <div class="hidden md:block mt-3 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Nama Pegawai</th>
                            <th scope="col" class="px-4 py-3">Profesi</th>
                            <th scope="col" class="px-4 py-3">Hari</th>
                            <th scope="col" class="px-4 py-3">Jam Mulai</th>
                            <th scope="col" class="px-4 py-3">Jam Selesai</th>
                            <th scope="col" class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jadwals as $jadwal)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $jadwal->pegawai->name }}</td>
                                <td class="px-4 py-3">
                                    {{ $jadwal->pegawai->getRoleNames()->first() ?? '-' }}
                                </td>

                                <td class="px-4 py-3">{{ $jadwal->hari }}</td>
                                <td class="px-4 py-3">{{ $jadwal->jam_mulai }}</td>
                                <td class="px-4 py-3">{{ $jadwal->jam_selesai }}</td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button id="actionsDropdownButton-{{ $jadwal->id }}"
                                        data-dropdown-toggle="actionsDropdown-{{ $jadwal->id }}"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700"
                                        type="button">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="actionsDropdown-{{ $jadwal->id }}"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="actionsDropdownButton-{{ $jadwal->id }}">
                                            <li>
                                                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus jadwal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data jadwal</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">
                        @if ($jadwals->count())
                            {{ $jadwals->firstItem() }}-{{ $jadwals->lastItem() }}
                        @else
                            0-0
                        @endif
                    </span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $jadwals->total() }}</span>
                </span>
                <div>
                    {{ $jadwals->links() }} <!-- Menampilkan link navigasi halaman -->
                </div>
            </nav>

        </div>
    </x-layout>
</x-app-layout>
