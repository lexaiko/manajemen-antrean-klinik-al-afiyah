{{-- resources/views/components/app-layout.blade.php --}}
@props(['hideNavbar' => false, 'header' => null])

@include('layouts.app', [
    'hideNavbar' => $hideNavbar,
    'header' => $header,
    'slot' => $slot,
])
