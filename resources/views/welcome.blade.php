@extends('layouts.main')

@section('content')
    @include('partials.navbar')
   <section style="background-image: url('{{ url('images/hero-bg.jpg') }}');" class="bg-center bg-no-repeat bg-gray-400 bg-blend-multiply bg-cover mt-6" data-aos="fade-down">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <h1 class="mb-4 text-2xl font-bold tracking-tight leading-none text-white md:text-5xl lg:text-5xl">
            Selamat Datang di Klinik Al Afiyah Banyuwangi
        </h1>
        <p class="mb-8 text-sm font-normal text-white lg:text-xl sm:px-16 lg:px-48">
            Daftar antrean secara online di Klinik Al Afiyah Banyuwangi. Daftar dari rumah dan dapatkan pengalaman berobat yang lebih cepat dan efisien.
        </p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
            <a href="{{ url('/daftar') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                Daftar Antrean Sekarang
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
            <a href="#tentang" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                Tentang Klinik Kami
            </a>
        </div>
    </div>
</section>

<section class="py-16 mt-3" id="layanan">
  <div class="max-w-screen-xl mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Intro Card -->
      <div class="bg-green-600 text-white p-6 rounded-lg shadow flex flex-col justify-between" data-aos="fade-up">
        <div>
          <h3 class="text-2xl font-bold mb-2">Sistem Antrean Online</h3>
          <p class="mb-4 text-sm">
            Ini adalah Sistem Antrean Online Klinik Al Afiyah di mana setiap pasien dapat mengambil antrean sesuai poliklinik dari rumah.
          </p>
        </div>
      </div>

      <!-- Poli Umum -->
      <div class="bg-white p-6 rounded-lg shadow text-center" data-aos="fade-down">
        <div class="text-green-600 mb-4 flex justify-center">
          <!-- Heroicon: User Circle -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M5.121 17.804A9 9 0 1118.88 6.197M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <h4 class="font-bold text-lg mb-2">Poli Umum</h4>
        <p class="text-sm text-gray-600">
          Pemeriksaan medis umum, pengobatan, dan edukasi untuk meningkatkan kesehatan pasien dan masyarakat.
        </p>
      </div>

      <!-- Poli Gigi -->
      <div class="bg-white p-6 rounded-lg shadow text-center" data-aos="fade-up">
        <div class="text-green-600 mb-4 flex justify-center">
          <!-- Heroicon: Sparkles (simbol gigi/bersih) -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
          </svg>
        </div>
        <h4 class="font-bold text-lg mb-2">Poli Gigi</h4>
        <p class="text-sm text-gray-600">
          Pemeriksaan dan perawatan kesehatan gigi dan mulut serta tindakan medis dasar untuk kesehatan gigi.
        </p>
      </div>

      <!-- Poli Kandungan -->
      <div class="bg-white p-6 rounded-lg shadow text-center" data-aos="fade-down">
        <div class="text-green-600 mb-4 flex justify-center">
          <!-- Heroicon: Heart -->
          <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
          </svg>
        </div>
        <h4 class="font-bold text-lg mb-2">Poli Kandungan</h4>
        <p class="text-sm text-gray-600">
          Layanan pemeriksaan dan pengobatan untuk kesehatan reproduksi wanita, termasuk kehamilan dan persalinan.
        </p>
      </div>

    </div>
  </div>
</section>

<section class="bg-gray-50 dark:bg-gray-800">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6" data-aos="fade-up">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div class="text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Layanan Kesehatan Terintegrasi</h2>
                    <p class="mb-8 font-light lg:text-xl">
                        Klinik Al Afiyah Banyuwangi menyediakan layanan kesehatan yang mudah diakses, mulai dari pendaftaran online, konsultasi dengan dokter, hingga pemantauan jadwal praktik dokter secara real-time.
                    </p>
                    <!-- List -->
                    <ul role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pendaftaran antrean secara online</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Konsultasi dengan dokter profesional</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Informasi jadwal dokter dan poliklinik</span>
                        </li>
                    </ul>
                    <p class="mb-8 font-light lg:text-xl">
                        Dapatkan kemudahan layanan kesehatan tanpa harus menunggu lama di klinik. Semua informasi dan layanan dapat diakses secara online.
                    </p>
                </div>
                <!-- Carousel/Slider Gambar Dokter dan Jadwal Praktik -->
                <div id="dokterCarousel" class="relative w-full mb-4 rounded-lg overflow-hidden">
                    <!-- Slides -->
                    <div class="carousel-slide">
                        <img src="{{ url('images/slide1.jpg') }}" class="w-full object-cover" alt="Gambar dokter dan jadwal praktik 1">
                    </div>
                    <div class="carousel-slide hidden">
                        <img src="{{ url('images/slide2.jpg') }}" class="w-full object-cover" alt="Gambar dokter dan jadwal praktik 2">
                    </div>
                    <div class="carousel-slide hidden">
                        <img src="{{ url('images/slide3.jpg') }}" class="w-full object-cover" alt="Gambar dokter dan jadwal praktik 3">
                    </div>
                    <!-- Controls -->
                    <button type="button" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white/70 rounded-full p-2 shadow hover:bg-white" onclick="prevSlide()">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button type="button" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white/70 rounded-full p-2 shadow hover:bg-white" onclick="nextSlide()">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <!-- Dots -->
                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2">
                        <button class="carousel-dot w-3 h-3 rounded-full bg-green-500" onclick="goToSlide(0)"></button>
                        <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300" onclick="goToSlide(1)"></button>
                        <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300" onclick="goToSlide(2)"></button>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16" data-aos="fade-up">
                <img class="w-full mb-4 rounded-lg lg:mb-0" src="{{ url('images/layanan.jpg') }}" alt="Fasilitas Laboratorium Klinik">
                <div class="text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Fasilitas Laboratorium Klinik</h2>
                    <p class="mb-8 font-light lg:text-xl">
                        Klinik Al Afiyah Banyuwangi menyediakan fasilitas laboratorium lengkap untuk mendukung diagnosa dan perawatan pasien secara cepat dan akurat.
                    </p>
                    <!-- List Fasilitas Laboratorium -->
                    <ul role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        <li class="flex space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pemeriksaan darah lengkap (hematologi)</span>
                        </li>
                        <li class="flex space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pemeriksaan urine lengkap</span>
                        </li>
                        <li class="flex space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pemeriksaan gula darah</span>
                        </li>
                        <li class="flex space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pemeriksaan kolesterol &amp; asam urat</span>
                        </li>
                        <li class="flex space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Rapid test (Anti HIV, malaria, dsb)</span>
                        </li>
                    </ul>
                    <p class="font-light lg:text-xl">
                        Didukung alat modern dan tenaga analis laboratorium berpengalaman untuk hasil yang cepat dan akurat.
                    </p>
                </div>
            </div>
        </div>
      </section>

    <section class="py-16 bg-white" id="berita" data-aos="fade-up">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Berita Klinik Al Afiyah</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ url('images/slide1.jpg') }}" alt="Berita 1" class="w-full h-56 object-cover">
                        <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            10 Jul 2024
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Klinik Al Afiyah Resmi Buka Layanan Laboratorium Baru</h3>
                        <a href="#" class="mt-auto inline-block text-green-600 hover:underline font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ url('images/slide2.jpg') }}" alt="Berita 2" class="w-full h-56 object-cover">
                        <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            28 Jun 2024
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Edukasi Kesehatan: Pentingnya Pemeriksaan Gigi Rutin</h3>
                        <a href="#" class="mt-auto inline-block text-green-600 hover:underline font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ url('images/slide3.jpg') }}" alt="Berita 3" class="w-full h-56 object-cover">
                        <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            15 Jun 2024
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Pelatihan Staf: Meningkatkan Layanan Pasien</h3>
                        <a href="#" class="mt-auto inline-block text-green-600 hover:underline font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-center">
                <a href="#" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition">
                    Lihat Semua Berita
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- End block -->
<section class="bg-white dark:bg-gray-900" id="faq" data-aos="fade-up">
    <div class="max-w-screen-xl px-4 pb-8 mx-auto lg:pb-24 lg:px-6 ">
        <h2 class="mb-6 text-3xl font-extrabold tracking-tight text-center text-gray-900 lg:mb-8 lg:text-3xl dark:text-white">Pertanyaan yang Sering Diajukan</h2>
        <div class="max-w-screen-md mx-auto">
            <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                <h3 id="accordion-flush-heading-1">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-900 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                        <span>Bagaimana cara mendaftar antrean online di Klinik Al Afiyah?</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-1" class="" aria-labelledby="accordion-flush-heading-1">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Anda dapat mendaftar antrean secara online melalui website ini dengan mengisi data diri dan memilih poliklinik yang diinginkan. Setelah mendaftar, Anda akan mendapatkan nomor antrean yang dapat dipantau secara real-time.</p>
                    </div>
                </div>
                <h3 id="accordion-flush-heading-2">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                        <span>Apakah saya harus datang lebih awal setelah mendaftar online?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Kami menyarankan Anda datang 10-15 menit sebelum nomor antrean Anda dipanggil untuk proses verifikasi dan administrasi di klinik.</p>
                    </div>
                </div>
                <h3 id="accordion-flush-heading-3">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                        <span>Apakah bisa memilih dokter saat mendaftar antrean?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Anda dapat memilih poliklinik dan dokter yang tersedia sesuai jadwal praktik yang tertera pada sistem antrean online kami.</p>
                    </div>
                </div>
                <h3 id="accordion-flush-heading-4">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-4" aria-expanded="false" aria-controls="accordion-flush-body-4">
                        <span>Bagaimana jika saya terlambat datang dari jadwal antrean?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Jika Anda terlambat, silakan konfirmasi ke petugas pendaftaran. Kami akan membantu menyesuaikan antrean Anda sesuai kondisi di klinik.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50" data-aos="zoom-in">
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
        <div class="mb-8 max-w-screen-md lg:mb-16">
            <h2 class="mb-4 text-4xl font-extrabold text-gray-900">Layanan Unggulan Klinik Al Afiyah</h2>
            <p class="text-gray-500 sm:text-xl">Kami menyediakan sistem antrean online, layanan konsultasi dokter, laboratorium, serta fasilitas modern untuk kenyamanan pasien.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Antrean Online</h3>
                <p class="text-gray-500">Daftar antrean dari rumah, pantau nomor secara real-time, dan hemat waktu tunggu di klinik.</p>
            </div>
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Konsultasi Dokter</h3>
                <p class="text-gray-500">Konsultasi dengan dokter umum, gigi, dan kandungan sesuai jadwal praktik yang tersedia.</p>
            </div>
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Laboratorium</h3>
                <p class="text-gray-500">Pemeriksaan laboratorium lengkap untuk mendukung diagnosa dan perawatan pasien.</p>
            </div>
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Fasilitas Nyaman</h3>
                <p class="text-gray-500">Ruang tunggu nyaman, area bermain anak, dan fasilitas pendukung lainnya untuk kenyamanan pasien.</p>
            </div>
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Informasi Jadwal Praktik</h3>
                <p class="text-gray-500">Jadwal dokter dan poliklinik selalu terupdate, bisa diakses kapan saja melalui website.</p>
            </div>
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold">Pelayanan Ramah</h3>
                <p class="text-gray-500">Tim kami siap membantu dan memberikan pelayanan terbaik untuk setiap pasien.</p>
            </div>
        </div>
    </div>
</section>

<section data-aos="flip-left">
    <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
        <div class="font-light text-gray-500 sm:text-lg">
            <h2 class="mb-4 text-4xl font-extrabold text-gray-900">Klinik Modern, Proses Mudah</h2>
            <p class="mb-4">Klinik Al Afiyah Banyuwangi mengutamakan kemudahan dan kenyamanan pasien melalui sistem antrean online, fasilitas lengkap, serta pelayanan profesional.</p>
            <p>Proses pendaftaran, pemeriksaan, hingga pengambilan hasil laboratorium dapat dilakukan dengan cepat dan efisien.</p>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-8">
            <img class="w-full rounded-lg" src="{{ url('images/layanan.jpg') }}" alt="Klinik Al Afiyah">
            <img class="mt-4 w-full rounded-lg lg:mt-10" src="{{ url('images/layanan.jpg') }}" alt="Fasilitas Klinik">
        </div>
    </div>
</section>

<section class="bg-gray-50" data-aos="fade-right">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="max-w-screen-lg text-gray-500 sm:text-lg">
            <h2 class="mb-4 text-4xl font-bold text-gray-900">Dipercaya oleh Ribuan Pasien</h2>
            <p class="mb-4 font-light">Ribuan pasien telah merasakan kemudahan layanan di Klinik Al Afiyah Banyuwangi. Sistem antrean online kami membantu mengurangi waktu tunggu dan meningkatkan kepuasan pasien.</p>
            <p class="mb-4 font-medium">Dapatkan pengalaman berobat yang lebih cepat, nyaman, dan modern bersama kami.</p>
            <a href="#daftar" class="inline-flex items-center font-medium text-green-600 hover:text-green-800">
                Daftar Sekarang
                <svg class="ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
    </div>
</section>

<section id="tentang" class="bg-white dark:bg-gray-900 py-16" data-aos="fade-up">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Kiri: Tentang Kami -->
        <div>
            <h2 class="mb-4 text-4xl font-extrabold text-gray-900 dark:text-white">Tentang Klinik Al Afiyah Banyuwangi</h2>
            <p class="mb-4 text-gray-700 dark:text-gray-300">
                Klinik Al Afiyah Banyuwangi adalah klinik pratama yang mengutamakan fasilitas kesehatan modern yang berkomitmen memberikan pelayanan terbaik bagi masyarakat. Kami menyediakan layanan medis umum, gigi, kandungan, serta laboratorium dengan sistem antrean online yang memudahkan pasien.
            </p>
            <p class="mb-4 text-gray-700 dark:text-gray-300">
                Didukung oleh tenaga medis profesional, fasilitas lengkap, dan teknologi terkini, Klinik Al Afiyah siap menjadi mitra kesehatan keluarga Anda. Kami selalu mengutamakan kenyamanan, keamanan, dan kepuasan pasien dalam setiap layanan.
            </p>
            <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300">
                <li>Pelayanan ramah dan profesional</li>
                <li>Sistem antrean online & real-time</li>
                <li>Fasilitas laboratorium lengkap</li>
                <li>Lokasi strategis di pusat kota Banyuwangi</li>
            </ul>
        </div>
        <!-- Kanan: Lokasi Google Maps -->
        <div>
            <div class="w-full h-80 rounded-lg overflow-hidden shadow-lg">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.870166273504!2d114.34431699999999!3d-8.3156986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1599b53196977%3A0x39fb4286d94b2c63!2sKLINIK%20AL%20AFIYAH%20MWCNU%20BLIMBINGSARI!5e0!3m2!1sid!2sid!4v1750600646249!5m2!1sid!2sid"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            </div>
            <p class="mt-3 text-gray-600 dark:text-gray-400 text-sm">
            Jl. Seroja, Dusun Pacemengan, Blimbingsari, Kec. Rogojampi, Kabupaten Banyuwangi, Jawa Timur 68462
            </p>
            <a href="https://maps.app.goo.gl/B6kHviTkrH6Up8dq7" target="_blank" rel="noopener" class="text-green-600 hover:underline text-sm flex items-center mt-1">
            Lihat di Google Maps
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3h7m0 0v7m0-7L10 14m-7 7h7a2 2 0 002-2v-7"></path>
            </svg>
            </a>
        </div>
    </div>
</section>
<script>
                    let currentSlide = 0;
                    const slides = document.querySelectorAll('#dokterCarousel .carousel-slide');
                    const dots = document.querySelectorAll('#dokterCarousel .carousel-dot');

                    function showSlide(idx) {
                        slides.forEach((slide, i) => {
                            slide.classList.toggle('hidden', i !== idx);
                        });
                        dots.forEach((dot, i) => {
                            dot.classList.toggle('bg-green-500', i === idx);
                            dot.classList.toggle('bg-gray-300', i !== idx);
                        });
                        currentSlide = idx;
                    }
                    function nextSlide() {
                        showSlide((currentSlide + 1) % slides.length);
                    }
                    function prevSlide() {
                        showSlide((currentSlide - 1 + slides.length) % slides.length);
                    }
                    function goToSlide(idx) {
                        showSlide(idx);
                    }
                    // Auto play (optional)
                    let autoPlay = setInterval(nextSlide, 5000);
                    // Pause on hover
                    document.getElementById('dokterCarousel').addEventListener('mouseenter', () => clearInterval(autoPlay));
                    document.getElementById('dokterCarousel').addEventListener('mouseleave', () => autoPlay = setInterval(nextSlide, 5000));
                    // Init
                    showSlide(0);
                </script>
@endsection
