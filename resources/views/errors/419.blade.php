@extends('layouts.main')
@php($hideNavbar = true)

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-12">
        <div class="text-center max-w-md">
            <h1 class="text-[100px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 drop-shadow-lg">
                419
            </h1>
            <p class="mt-4 text-2xl font-semibold text-gray-800">
                Session Kadaluarsa
            </p>
            <p class="mt-2 text-gray-600">
                Sepertinya kamu terlalu lama diam atau token CSRF tidak valid. Silakan refresh halaman dan coba lagi.
            </p>
            <a href="{{ url()->previous() }}"
               class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-blue-500 to-teal-500 text-white rounded-lg shadow-lg hover:scale-105 transition duration-300">
                Kembali ke Halaman Sebelumnya
            </a>
        </div>
    </div>
@endsection
