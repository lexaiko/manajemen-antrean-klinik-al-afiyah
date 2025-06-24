<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r-2 border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">

        <ul class="space-y-2">
            <li>
                <a href="/admin/dashboard"
                    class="flex items-center p-2 text-base font-medium {{ request()->is('admin/dashboard') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg dark:text-white dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/dashboard') ? 'white' : 'black' }}"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="dropdown-example"
                aria-expanded="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? 'true' : 'false' }}"
                data-collapse-toggle="dropdown-example">
                <!-- Icon SVG Produk -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? 'white' : 'black' }}"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                <svg class="w-3 h-3 {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? 'text-white' : 'text-gray-800' }}"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="dropdown-example"
                class="{{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? '' : 'hidden' }} py-2 space-y-2">
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
                @role('admin klinik')
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
                        <span class="ml-3">Peran</span>
                    </a>
                </li>
                @endrole
                <li>
                    <a href="{{ url('admin/poli') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/poli*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-hospital-icon lucide-hospital">
                            <path d="M12 6v4" />
                            <path d="M14 14h-4" />
                            <path d="M14 18h-4" />
                            <path d="M14 8h-4" />
                            <path d="M18 12h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h2" />
                            <path d="M18 22V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v18" />
                        </svg>
                        <span class="ml-3">Poli</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">

            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/antrean*') || request()->is('admin/antrean/{id}/detail*') || request()->is('/admin/antrean/create*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="manajemen-antrean"
                aria-expanded="{{ request()->is('admin/antrean*') || request()->is('admin/monitoring*') ? 'true' : 'false' }}"
                data-collapse-toggle="manajemen-antrean">
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
                <svg class="w-3 h-3 {{ request()->is('admin/antrean*') || request()->is('admin/antrean/{id}/detail*') ? 'text-white' : 'text-gray-800' }}"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <ul id="manajemen-antrean"
                class="{{ request()->is('admin/monitoring*') || request()->is('admin/antrean*') ? '' : 'hidden' }} py-2 space-y-2 ">
                <li>
                    @role('admin klinik')
                    <a href="{{ route('admin.monitoring') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/monitoring') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-monitor-icon lucide-monitor">
                            <rect width="20" height="14" x="2" y="3" rx="2" />
                            <line x1="8" x2="16" y1="21" y2="21" />
                            <line x1="12" x2="12" y1="17" y2="21" />
                        </svg>
                        <span class="ml-3">Monitoring Antrean</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.antrean.control.index') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/antrean/control*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-monitor-icon lucide-monitor">
                            <rect width="20" height="14" x="2" y="3" rx="2" />
                            <line x1="8" x2="16" y1="21" y2="21" />
                            <line x1="12" x2="12" y1="17" y2="21" />
                        </svg>
                        <span class="ml-3">Kontrol Antrean</span>
                    </a>
                </li>
                @endrole
                <li>
                    <a href="{{ route('admin.antrian.index') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/antrean') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/antrean') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-list-start-icon lucide-list-start">
                            <path d="M16 12H3" />
                            <path d="M16 18H3" />
                            <path d="M10 6H3" />
                            <path d="M21 18V8a2 2 0 0 0-2-2h-5" />
                            <path d="m16 8-2-2 2-2" />
                        </svg>
                        <span class="ml-3">Antrean Hari Ini</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.antrian.riwayat') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/antrean/riwayat') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-list-end-icon lucide-list-end">
                            <path d="M16 12H3" />
                            <path d="M16 6H3" />
                            <path d="M10 18H3" />
                            <path d="M21 6v10a2 2 0 0 1-2 2h-5" />
                            <path d="m16 16-2 2 2 2" />
                        </svg>
                        <span class="ml-3">Riwayat Antrean</span>
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
                    fill="none" stroke="{{ request()->is('admin/jadwal*') ? 'white' : 'black' }}"
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
                        <span class="ml-3">Jadwal Pegawai</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">
            @role('admin klinik')
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group {{ request()->is('admin/berita*') || request()->is('admin/kategori*') ? 'bg-green-600 text-white' : '' }}"
                    aria-controls="manajemen-berita"
                    aria-expanded="{{ request()->is('admin/berita*') || request()->is('admin/kategori*') ? 'true' : 'false' }}"
                    data-collapse-toggle="manajemen-berita">
                    <!-- Icon SVG Produk -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="{{ request()->is('admin/berita*') ? 'white' : 'black' }}"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-newspaper-icon lucide-newspaper">
                        <path d="M15 18h-5" />
                        <path d="M18 14h-8" />
                        <path
                            d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                        <rect width="8" height="4" x="10" y="6" rx="1" />
                    </svg>
                    <!-- Teks Produk -->
                    <span class="flex-1  text-base font-medium ml-3 text-left whitespace-nowrap">Manajemen Berita</span>

                    <!-- Icon Dropdown -->
                    <svg class="w-3 h-3 {{ request()->is('admin/berita*') ? 'text-white' : 'text-gray-800' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="manajemen-berita" class="{{ request()->is('admin/berita*') ? '' : 'hidden' }} py-2 space-y-2 ">
                    <li>
                        <a href="{{ url('admin/berita') }}"
                            class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/berita*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="{{ request()->is('admin/berita*') ? 'white' : 'black' }}"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chart-column-stacked-icon lucide-chart-column-stacked">
                                <path d="M11 13H7" />
                                <path d="M19 9h-4" />
                                <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                                <rect x="15" y="5" width="4" height="12" rx="1" />
                                <rect x="7" y="8" width="4" height="9" rx="1" />
                            </svg>
                            <span class="ml-3">Kelola berita</span>
                        </a>
                    </li>
                </ul>
                <hr class="border-gray-200 dark:border-gray-700">
            @endrole

    </div>
</aside>
