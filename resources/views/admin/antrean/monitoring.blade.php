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

        <div class=" relative z-10 flex justify-center items-center  ">

            <div class=" p-2 bg-white shadow-xl rounded-lg -mt-10 mb-5 w-4/5 sm:w-3/4 lg:w-4/5 ">
                <div class='flex flex-col lg:flex-row justify-center items-center '>
                    <div class=' w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-green-700 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col'>
                            <h1 class='font-bold text-xl text-white'>
                                Sedang Dilayani
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1'>                                
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white '>
                                PU001
                            </h1>
                        </div>
                    </div>
                    <div class='w-4/5 sm:w-1/2 lg:w-2/5 p-2 bg-gray-700 mx-10 mt-5 rounded-lg mb-5'>
                        <div class='flex justify-center items-center flex-col '>
                            <h1 class='font-bold text-xl text-white'>
                                Antrian Selanjutnya
                            </h1>
                            <div class='border-t border-white w-4/5 mt-1 '>                                
                            </div>
                            <h1 class='text-4xl font-bold my-10 text-white'>
                                PG001
                                
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('partials.footer')