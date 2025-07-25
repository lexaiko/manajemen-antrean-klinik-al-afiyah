<x-app-layout>
    <x-layout>
        @if (session()->has('success'))
            <div id="alert-2"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-3 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="/admin/berita"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Berita</a>
                    </div>
                </li>
            </ol>
        </nav>
        <h3 class="text-xl font-bold dark:text-white px-4 lg:px-12">Daftar Berita</h3>
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 p-4">

                {{-- search --}}
                <div class="flex items-center w-full">
                    <form action="{{ route('admin.berita.search') }}" method="GET"
                        class="flex items-center w-full max-w-md space-x-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="query" placeholder="Cari Berita..."
                                value="{{ request()->query('query') }}"
                                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Cari
                        </button>
                    </form>
                </div>
                {{-- end search --}}


                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a href="{{ route('admin.berita.create')}}" class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Berita
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>

                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Judul</th>
                            <th scope="col" class="px-4 py-3">Konten</th>
                            <th scope="col" class="px-4 py-3">Gambar</th>
                            <th scope="col" class="px-4 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beritas as $berita)
                            <tr class="border-b dark:border-gray-700">

                                <td class="px-4 py-3">
                                    {{ ($beritas->currentPage() - 1) * $beritas->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $berita->judul }}</td>
                                <td class="px-4 py-3" style="max-width: 300px; word-wrap: break-word; text-align: justify;">
                                    {{ strip_tags($berita->konten) }}
                                </td>
                                <td class="px-4 py-3" style="display: none;">
                                    <input type="hidden" name="tgl_published" value="{{ $berita->tgl_published }}">
                                    {{ \Carbon\Carbon::parse($berita->tgl_published)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>
                                <td class="px-4 py-3" style="display: none;">
                                    <input type="hidden" name="nama_published"
                                        value="{{ $berita->nama_published }}">
                                    {{ $berita->nama_published }}
                                </td>

                                <td class="px-4 py-3">
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Image"
                                    class="w-16 md:w-24">
                            </td>
                                <td class="px-4 py-3 flex items-center">
                                    <button id="actionsDropdownButton-{{ $berita->id }}"
                                        data-dropdown-toggle="actionsDropdown-{{ $berita->id }}"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700"
                                        type="button">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>

                                    <div id="actionsDropdown-{{ $berita->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton-{{ $berita->id }}">
                                            <li>
                                                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus Berita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">
                        @if ($beritas->count())
                            {{ $beritas->firstItem() }}-{{ $beritas->lastItem() }}
                        @else
                            0-0
                        @endif
                    </span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $beritas->total() }}</span>
                </span>

                <!-- Dynamic Pagination Links -->
                <div>
                    {{ $beritas->links() }} <!-- Menampilkan link navigasi halaman -->
                </div>
            </nav>

        </div>
        <script>
            document.getElementById('dropdownButton').addEventListener('click', function() {
                var dropdownMenu = document.getElementById('dropdownMenu');
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown if click outside
            document.addEventListener('click', function(event) {
                var dropdownMenu = document.getElementById('dropdownMenu');
                if (!event.target.closest('#dropdownButton') && !event.target.closest('#dropdownMenu')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        </script>
        <script>
            // silang x allert
            document.addEventListener('DOMContentLoaded', function() {
                // Temukan semua button dengan data-dismiss-target
                const dismissButtons = document.querySelectorAll('[data-dismiss-target]');

                dismissButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-dismiss-target');
                        const alertElement = document.querySelector(targetId);

                        if (alertElement) {
                            alertElement.classList.add(
                                'hidden'); // Tambah class hidden untuk menyembunyikan alert
                        }
                    });
                });
            });
        </script>
        <script>
            const searchInput = document.getElementById('search-input');

            searchInput.addEventListener('input', function() {
                if (this.value === '') {
                    // Jika input kosong, redirect ke halaman index
                    window.location.href = '/berita';
                }
            });
        </script>
    </x-layout>
</x-app-layout>
