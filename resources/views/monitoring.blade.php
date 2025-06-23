@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <section class="jumbotron w-full h-3/4 md:h-screen">
        <div class="relative w-full h-3/4 overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ url('images/hero-bg.jpg') }}" alt="">
            <div
                class="absolute inset-0 flex flex-col justify-center items-start bg-black/30 bg-opacity-30 text-white text-left pl-[100px] lg:pl-[300px] ">
                <h1 class="text-2xl md:text-4xl font-bold mb-2">Selamat Datang</h1>
                <p class="text-sm md:text-lg mb-3">di Klinik Al Afiyah Blimbingsari</p>
            </div>
        </div>
        <div class=" relative z-10 flex justify-center items-center">
            <div class=" p-2 bg-white shadow-xl rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5 ">
                <div>
                    <p class="font-bold text-center text-green-600">Poli Umum</p>
                    <div class="flex justify-center">
                        <div class='border-t border-gray-600 w-11/12 mt-1 flex justify-center'></div>
                    </div>
                </div>
                <div class='flex flex-col lg:flex-row justify-center items-center '>
                    <div class=' w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-green-600 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col'>
                            <h1 class='font-bold text-xl text-white'>
                                Sedang Dilayani
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1'>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white '>
                                {{ $dilayani_du->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                    <div class='w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-gray-600 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col '>
                            <h1 class='font-bold text-xl text-white'>
                                Antrean Selanjutnya
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1 '>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white'>
                                {{ $duberikutnya->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-bold text-center text-green-600">Poli Gigi</p>
                    <div class="flex justify-center">
                        <div class='border-t border-gray-600 w-11/12 mt-1 flex justify-center'></div>
                    </div>
                </div>
                <div class='flex flex-col lg:flex-row justify-center items-center '>                   
                    <div class=' w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-green-600 mx-10 mt-5 rounded-lg mb-5'>                        
                        <div class='flex justify-center items-center flex-col'>
                            <h1 class='font-bold text-xl text-white'>
                                Sedang Dilayani
                            </h1>
                            <div class='border-t border-white w-11/12 mt-1'>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white '>
                                {{ $dilayani_dg->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                    <div class='w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-gray-700 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col '>
                            <h1 class='font-bold text-xl text-white'>
                                Antrean Selanjutnya
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1 '>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white'>
                                {{ $dgberikutnya->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-bold text-center text-green-600">Poli KIA</p>
                    <div class="flex justify-center">
                        <div class='border-t border-gray-600 w-11/12 mt-1 flex justify-center'></div>
                    </div>
                </div>
                <div class='flex flex-col lg:flex-row justify-center items-center '>
                    <div class=' w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-green-700 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col'>
                            <h1 class='font-bold text-xl text-white'>
                                Sedang Dilayani
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1'>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white '>
                                {{ $dilayani_kia->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                    <div class='w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-gray-700 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col '>
                            <h1 class='font-bold text-xl text-white'>
                                Antrean Selanjutnya
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1 '>
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white'>
                                {{ $kiaberikutnya->nomor_antrian ?? 'Selesai' }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@include('partials.footer')
