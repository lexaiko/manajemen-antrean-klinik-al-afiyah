<nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('beranda') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ url('images/logo.png') }}" class="h-8" alt="Flowbite Logo">
            <span class="hidden md:block self-center text-xl font-semibold whitespace-nowrap">Klinik Al Afiyah</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button"
                class="text-white bg-green-600 hover:bg-green-600 focus:ring-4 focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                <nav class="flex items-center justify-end gap-4">
                    <a href="{{ route('antrean.index') }}">
                        Antrean Saat Ini
                    </a>
                </nav>
            </button>
            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                <li>
                    <a href="{{ url('/') }}"
                        class="block py-2 px-3 rounded-sm md:bg-transparent md:p-0
                           {{ request()->is('/') ? 'text-green-600 bg-green-100 md:text-green-600' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-600' }}"
                        aria-current="{{ request()->is('/') ? 'page' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('jadwal.index') }}"
                        class="block py-2 px-3 rounded-sm md:bg-transparent md:p-0
                           {{ request()->routeIs('jadwal.index') ? 'text-green-600 bg-green-100 md:text-green-600' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-600' }}">
                        Jadwal Dokter
                    </a>
                </li>
                <li>
                    <a href="{{ route('berita.index') }}"
                        class="block py-2 px-3 rounded-sm md:bg-transparent md:p-0
                           {{ request()->routeIs('berita.index') ? 'text-green-600 bg-green-100 md:text-green-600' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-600' }}">
                        Berita
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
