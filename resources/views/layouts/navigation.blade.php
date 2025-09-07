<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b-2 border-gray-200 dark:border-gray-700 sticky-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex ">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ url('images/logo.png') }}" class="w-12 h-12" alt="" srcset="">
                    </a>
                </div>
                <!-- Navigation Links -->
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown aligg="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="dropdown-link">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-link">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Tambahkan menu sidebar di bawah ini -->
        <div class="pt-2 pb-3 space-y-1">
            <!-- Master Data Dropdown -->
            <details class="group" {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/poli*') ? 'open' : '' }}>
                <summary class="flex items-center px-4 py-2 cursor-pointer font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <span class="flex-1">Master Data</span>
                    <svg class="w-4 h-4 ml-2 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="pl-6">
                    <a href="{{ url('admin/user') }}" class="block py-2 {{ request()->is('admin/user*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Pegawai</a>
                    @role('admin klinik')
                    <a href="{{ url('admin/role') }}" class="block py-2 {{ request()->is('admin/role*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Peran</a>
                    @endrole
                    <a href="{{ url('admin/poli') }}" class="block py-2 {{ request()->is('admin/poli*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Poli</a>
                </div>
            </details>
            <!-- Manajemen Antrean Dropdown -->
            <details class="group" {{ request()->is('admin/monitoring*') || request()->is('admin/antrean*') ? 'open' : '' }}>
                <summary class="flex items-center px-4 py-2 cursor-pointer font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <span class="flex-1">Manajemen Antrean</span>
                    <svg class="w-4 h-4 ml-2 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="pl-6">
                    @role('admin klinik')
                    <a href="{{ route('admin.monitoring') }}" class="block py-2 {{ request()->is('admin/monitoring') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Monitoring Antrean</a>
                    <a href="{{ route('admin.antrean.control.index') }}" class="block py-2 {{ request()->is('admin/antrean/control*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Kontrol Antrean</a>
                    @endrole
                    <a href="{{ route('admin.antrian.index') }}" class="block py-2 {{ request()->is('admin/antrean') ? 'text-green-600 font-bold' : 'text-gray-700' }}">List Antrean</a>
                    <a href="{{ route('admin.antrian.riwayat') }}" class="block py-2 {{ request()->is('admin/antrean/riwayat') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Riwayat Antrean</a>
                </div>
            </details>
            <!-- Manajemen Jadwal Dropdown -->
            <details class="group" {{ request()->is('admin/jadwal*') || request()->is('admin/kategori*') ? 'open' : '' }}>
                <summary class="flex items-center px-4 py-2 cursor-pointer font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <span class="flex-1">Manajemen Jadwal</span>
                    <svg class="w-4 h-4 ml-2 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="pl-6">
                    <a href="{{ url('admin/jadwal') }}" class="block py-2 {{ request()->is('admin/jadwal') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Jadwal Pegawai</a>
                </div>
            </details>
            <!-- Manajemen Berita Dropdown -->
            @role('admin klinik')
            <details class="group" {{ request()->is('admin/berita*') ? 'open' : '' }}>
                <summary class="flex items-center px-4 py-2 cursor-pointer font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <span class="flex-1">Manajemen Berita</span>
                    <svg class="w-4 h-4 ml-2 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="pl-6">
                    <a href="{{ url('admin/berita') }}" class="block py-2 {{ request()->is('admin/berita*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Kelola Berita</a>
                </div>
            </details>
            @endrole
            <!-- Manajemen Laporan Dropdown -->
            <details class="group" {{ request()->is('admin/laporan*') ? 'open' : '' }}>
                <summary class="flex items-center px-4 py-2 cursor-pointer font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <span class="flex-1">Laporan</span>
                    <svg class="w-4 h-4 ml-2 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="pl-6">
                    <a href="{{ route('admin.laporan.antrean') }}" class="block py-2 {{ request()->is('admin/laporan/antrean*') ? 'text-green-600 font-bold' : 'text-gray-700' }}">Laporan Antrean</a>
                </div>
            </details>
        </div>
        <!-- End menu sidebar mobile -->

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="nav-link">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<style>
    .sticky-nav {
        position: sticky;
        top: 0;
        background-color: white; /* Warna coklat */
        z-index: 1000; /* Supaya berada di depan konten lain */
    }

    .sticky-nav .nav-link, .sticky-nav .dropdown-link {
        color: black;   
    }
</style>
