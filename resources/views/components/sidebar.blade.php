<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r-2 border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">

        <ul class="space-y-2">
            <li>
                <a href="/dashboard"
                    class="flex items-center p-2 text-base font-medium {{ request()->is('dashboard') || request()->is('dashboard') || request()->is('dashboard') || request()->has('query') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg dark:text-white dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('dashboard') ? 'white' : 'black' }}" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <hr class="border-gray-200 dark:border-gray-700">

            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/tenagamedis*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="dropdown-example"
                aria-expanded="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/tenagamedis*') ? 'true' : 'false' }}"
                data-collapse-toggle="dropdown-example">
                <!-- Icon SVG Produk -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/tenagamedis*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-text-icon lucide-file-text">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>

                <!-- Teks Produk -->
                <span class="flex-1  text-base font-medium  ml-3 text-left whitespace-nowrap">Master Data</span>

                <!-- Icon Dropdown -->
                <svg class="w-3 h-3 {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/tenagamedis*') ? 'text-white' : 'text-gray-800' }}" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="dropdown-example"
                class="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/tenagamedis*') ? '' : 'hidden' }} py-2 space-y-2">
                <li>
                    <a href="{{ url('admin/user') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/user*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/user*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="ml-3">Pegawai</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/role') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/role*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/role*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="ml-3">Role</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">

            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/produk*') || request()->is('admin/kategori*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="dropdown-2"
                aria-expanded="{{ request()->is('admin/produk*') || request()->is('admin/kategori*') ? 'true' : 'false' }}"
                data-collapse-toggle="dropdown-2">
                <!-- Icon SVG Produk -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-logs-icon lucide-logs">
                    <path d="M13 12h8" />
                    <path d="M13 18h8" />
                    <path d="M13 6h8" />
                    <path d="M3 12h1" />
                    <path d="M3 18h1" />
                    <path d="M3 6h1" />
                    <path d="M8 12h1" />
                    <path d="M8 18h1" />
                    <path d="M8 6h1" />
                </svg>

                <!-- Teks Produk -->
                <span class="flex-1  text-base font-medium ml-3 text-left whitespace-nowrap">Manajemen Antrean</span>

                <!-- Icon Dropdown -->
                <svg class="w-3 h-3 {{ request()->is('admin/produk*') || request()->is('admin/kategori*') ? 'text-white' : 'text-gray-800' }}"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <ul id="dropdown-2"
                class="{{ request()->is('admin/produk*') || request()->is('admin/kategori*') ? '' : 'hidden' }} py-2 space-y-2 ">
                <li>
                    <a href="{{ url('admin/produk') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/produk') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-list-minus-icon lucide-list-minus">
                            <path d="M11 12H3" />
                            <path d="M16 6H3" />
                            <path d="M16 18H3" />
                            <path d="M21 12h-6" />
                        </svg>
                        <span class="ml-3">Monitoring Antrean</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/produk') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/produk') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-list-start-icon lucide-list-start">
                            <path d="M16 12H3" />
                            <path d="M16 18H3" />
                            <path d="M10 6H3" />
                            <path d="M21 18V8a2 2 0 0 0-2-2h-5" />
                            <path d="m16 8-2-2 2-2" />
                        </svg>
                        <span class="ml-3">Antrean Online</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/produk') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/produk') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-list-end-icon lucide-list-end">
                            <path d="M16 12H3" />
                            <path d="M16 6H3" />
                            <path d="M10 18H3" />
                            <path d="M21 6v10a2 2 0 0 1-2 2h-5" />
                            <path d="m16 16-2 2 2 2" />
                        </svg>
                        <span class="ml-3">Antrean Offline</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">
            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/jadwal*') || request()->is('admin/kategori*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="manajemen-jadwal"
                aria-expanded="{{ request()->is('admin/jadwal*') || request()->is('admin/kategori*') ? 'true' : 'false' }}"
                data-collapse-toggle="manajemen-jadwal">
                <!-- Icon SVG Produk -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none"
                    stroke="{{ request()->is('admin/jadwal*') ? 'white' : 'black' }}"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-check-icon lucide-calendar-check">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                    <path d="m9 16 2 2 4-4" />
                </svg>

                <!-- Teks Produk -->
                <span class="flex-1  text-base font-medium ml-3 text-left whitespace-nowrap">Manajemen Jadwal</span>

                <!-- Icon Dropdown -->
                <svg class="w-3 h-3 {{ request()->is('admin/jadwal*') || request()->is('admin/kategori*') ? 'text-white' : 'text-gray-800' }}"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <ul id="manajemen-jadwal"
                class="{{ request()->is('admin/jadwal*') || request()->is('admin/kategori*') ? '' : 'hidden' }} py-2 space-y-2 ">
                <li>
                    <a href="{{ url('admin/jadwal') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/jadwal') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/jadwal') ? 'white' : 'black' }}"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                            <path d="M11 13H7" />
                            <path d="M19 9h-4" />
                            <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                            <rect x="15" y="5" width="4" height="12" rx="1" />
                            <rect x="7" y="8" width="4" height="9" rx="1" />
                        </svg>
                        <span class="ml-3">Kelola Jadwal</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/jadwal/kalender') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/jadwal/kalender*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/jadwal/kalender') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-calendar-days-icon lucide-calendar-days">
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <rect width="18" height="18" x="3" y="4" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 14h.01" />
                            <path d="M12 14h.01" />
                            <path d="M16 14h.01" />
                            <path d="M8 18h.01" />
                            <path d="M12 18h.01" />
                            <path d="M16 18h.01" />
                        </svg>
                        <span class="ml-3">Kalender Jadwal</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/artikel*') || request()->is('admin/kategori*') ? 'bg-green-600 text-white' : '' }}"
            aria-controls="manajemen-artikel"
            aria-expanded="{{ request()->is('admin/artikel*') || request()->is('admin/kategori*') ? 'true' : 'false' }}"
            data-collapse-toggle="manajemen-artikel">
            <!-- Icon SVG Produk -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/artikel*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper"><path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/></svg>
            <!-- Teks Produk -->
            <span class="flex-1  text-base font-medium ml-3 text-left whitespace-nowrap">Manajemen Artikel</span>

            <!-- Icon Dropdown -->
            <svg class="w-3 h-3 {{ request()->is('admin/artikel*') || request()->is('admin/kategori*') ? 'text-white' : 'text-gray-800' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>
        <ul id="manajemen-artikel"
            class="{{ request()->is('admin/artikel*') || request()->is('admin/kategori*') ? '' : 'hidden' }} py-2 space-y-2 ">
            <li>
                <a href="{{ url('admin/artikel/kategori') }}"
                    class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/artikel/kategori*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/artikel/kategori') ? 'white' : 'black' }}"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                        <path d="M11 13H7" />
                        <path d="M19 9h-4" />
                        <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                        <rect x="15" y="5" width="4" height="12" rx="1" />
                        <rect x="7" y="8" width="4" height="9" rx="1" />
                    </svg>
                    <span class="ml-3">Kelola artikel</span>
                </a>
            </li>
        </ul>
        <hr class="border-gray-200 dark:border-gray-700">
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/konten*') || request()->is('admin/kategori*') ? 'bg-green-600 text-white' : '' }}"
            aria-controls="manajemen-konten"
            aria-expanded="{{ request()->is('admin/konten*') || request()->is('admin/kategori*') ? 'true' : 'false' }}"
            data-collapse-toggle="manajemen-konten">
            <!-- Icon SVG Produk -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/konten*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette-icon lucide-palette"><path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"/><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/></svg>

            <!-- Teks Produk -->
            <span class="flex-1  text-base font-medium ml-3 text-left whitespace-nowrap">Manajemen Konten</span>

            <!-- Icon Dropdown -->
            <svg class="w-3 h-3 {{ request()->is('admin/konten*') || request()->is('admin/kategori*') ? 'text-white' : 'text-gray-800' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>
        <ul id="manajemen-konten"
            class="{{ request()->is('admin/konten*') || request()->is('admin/kategori*') ? '' : 'hidden' }} py-2 space-y-2 ">
            <li>
                <a href="{{ url('admin/konten/kategori') }}"
                    class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/konten/kategori*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/konten/kategori') ? 'white' : 'black' }}"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                        <path d="M11 13H7" />
                        <path d="M19 9h-4" />
                        <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                        <rect x="15" y="5" width="4" height="12" rx="1" />
                        <rect x="7" y="8" width="4" height="9" rx="1" />
                    </svg>
                    <span class="ml-3">Konfigurasi Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/konten') }}"
                    class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/konten') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/konten') ? 'white' : 'black' }}"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                        <path d="M11 13H7" />
                        <path d="M19 9h-4" />
                        <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                        <rect x="15" y="5" width="4" height="12" rx="1" />
                        <rect x="7" y="8" width="4" height="9" rx="1" />
                    </svg>
                    <span class="ml-3">Kelola Galeri</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/konten') }}"
                    class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/konten') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/konten') ? 'white' : 'black' }}"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                        <path d="M11 13H7" />
                        <path d="M19 9h-4" />
                        <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                        <rect x="15" y="5" width="4" height="12" rx="1" />
                        <rect x="7" y="8" width="4" height="9" rx="1" />
                    </svg>
                    <span class="ml-3">Kelola Sosmed</span>
                </a>
            </li>
        </ul>
        <hr class="border-gray-200 dark:border-gray-700">
        <ul class="pt-5 mt-5 space-y-2 ">
            <li>
                <a href="/profile"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group {{ request()->is('role*') ? 'active-sidebar-item' : '' }}">
                    <svg class="w-[31px] h-[31px] text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="ml-3">Profile</span>
                </a>
            </li>
        </ul>

    </div>
</aside>
