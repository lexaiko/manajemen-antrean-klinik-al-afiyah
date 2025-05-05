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
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group  {{ request()->is('admin/user*') || request()->is('admin/tenagamedis*') ? 'bg-green-600 text-white' : '' }}"
                aria-controls="dropdown-example"
                aria-expanded="{{ request()->is('admin/user*') || request()->is('admin/tenagamedis*') ? 'true' : 'false' }}"
                data-collapse-toggle="dropdown-example">
                <!-- Icon SVG Produk -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('admin/user*') || request()->is('admin/tenagamedis*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>

                <!-- Teks Produk -->
                <span class="flex-1  text-base font-medium  ml-3 text-left whitespace-nowrap">Master Data</span>

                <!-- Icon Dropdown -->
                <svg class="w-3 h-3 {{ request()->is('admin/user*') || request()->is('admin/tenagamedis*') ? 'text-white' : 'text-gray-800' }}"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <ul id="dropdown-example" class="{{ request()->is('admin/user*') || request()->is('admin/tenagamedis*') ? '' : 'hidden' }} py-2 space-y-2">
                <li>
                    <a href="{{ url('admin/user') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/user*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/user*') ? 'white' : 'black' }}" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="ml-3">User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/tenagamedis/filter/dokter') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/tenagamedis/filter/dokter*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/tenagamedis/filter/dokter*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-stethoscope-icon lucide-stethoscope"><path d="M11 2v2"/><path d="M5 2v2"/><path d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1"/><path d="M8 15a6 6 0 0 0 12 0v-3"/><circle cx="20" cy="10" r="2"/></svg>
                        <span class="ml-3">Dokter</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/tenagamedis/filter/perawat') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/tenagamedis/filter/perawat*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="{{ request()->is('admin/tenagamedis/filter/perawat*') ? 'white' : 'black' }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-briefcase-medical-icon lucide-briefcase-medical">
                            <path d="M12 11v4" />
                            <path d="M14 13h-4" />
                            <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                            <path d="M18 6v14" />
                            <path d="M6 6v14" />
                            <rect width="20" height="14" x="2" y="6" rx="2" />
                        </svg>
                        <span class="ml-3">Perawat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/tenagamedis/filter/bidan') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/tenagamedis/filter/bidan*') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/tenagamedis/filter/bidan*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-baby-icon lucide-baby"><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M15 12h.01"/><path d="M19.38 6.813A9 9 0 0 1 20.8 10.2a2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/><path d="M9 12h.01"/></svg>
                        <span class="ml-3">Bidan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/tenagamedis/filter/') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/tenagamedis/filter') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/tenagamedis/filter') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                        <span class="ml-3">Tenaga Medis</span>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-logs-icon lucide-logs"><path d="M13 12h8"/><path d="M13 18h8"/><path d="M13 6h8"/><path d="M3 12h1"/><path d="M3 18h1"/><path d="M3 6h1"/><path d="M8 12h1"/><path d="M8 18h1"/><path d="M8 6h1"/></svg>

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-minus-icon lucide-list-minus"><path d="M11 12H3"/><path d="M16 6H3"/><path d="M16 18H3"/><path d="M21 12h-6"/></svg>
                        <span class="ml-3">Monitoring Antrean</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/produk') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/produk') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-start-icon lucide-list-start"><path d="M16 12H3"/><path d="M16 18H3"/><path d="M10 6H3"/><path d="M21 18V8a2 2 0 0 0-2-2h-5"/><path d="m16 8-2-2 2-2"/></svg>
                        <span class="ml-3">Antrean Online</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/produk') }}"
                        class="flex items-center w-full p-2 text-base font-medium {{ request()->is('admin/produk') ? 'bg-green-600 text-white hover:bg-green-600 hover:text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-lg pl-2 group dark:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->is('admin/antrean*') ? 'white' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-end-icon lucide-list-end"><path d="M16 12H3"/><path d="M16 6H3"/><path d="M10 18H3"/><path d="M21 6v10a2 2 0 0 1-2 2h-5"/><path d="m16 16-2 2 2 2"/></svg>
                        <span class="ml-3">Antrean Offline</span>
                    </a>
                </li>
            </ul>
            <hr class="border-gray-200 dark:border-gray-700">
        </ul>
        <ul class="pt-5 mt-5 space-y-2 ">
            <li>
                <a href="/profile"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group {{ request()->is('staff*') ? 'active-sidebar-item' : '' }}">
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
