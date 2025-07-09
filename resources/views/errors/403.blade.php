@extends('layouts.main')
@php($hideNavbar = true)

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-white to-gray-100 px-4 py-12">
        <div class="text-center max-w-md">
            <h1 class="text-[100px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-yellow-500 to-pink-500 drop-shadow-lg">
                403
            </h1>
            <p class="mt-4 text-2xl font-semibold text-gray-800">
                Akses Dilarang!
            </p>
            <p class="mt-2 text-gray-600">
                Kamu tidak punya izin untuk mengakses halaman ini. Mungkin login sebagai user lain?
            </p>
            <a href="{{ url('/') }}"
               class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-lg hover:scale-105 transition duration-300">
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
