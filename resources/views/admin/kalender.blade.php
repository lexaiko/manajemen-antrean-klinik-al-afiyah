<x-app-layout>
    <x-layout>
        @if (session()->has('success'))
        <div id="alert-2"
            class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-2" aria-label="Close">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        @endif
<div class="container mx-auto w-full border-2">
    <div class="flex justify-center">
        <div class="w-full">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-800 text-white px-6 py-3">
                    Calendar
                </div>

                <div class="p-6">
                    @if(session('status'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="w-32 text-left py-3 px-4 border-l  border-r border-b bg-gray-200">Time</th>
                                @foreach($weekDays as $day)
                                    <th class="text-left py-3 px-4 border-l border-r border-b bg-gray-200">{{ $day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calendarData as $time => $days)
                                <tr>
                                    <td class="border border-gray-200 py-3 px-4">{{ $time }}</td>
                                    @foreach($days as $value)
                                        @if (is_array($value))
                                            <td rowspan="{{ $value['rowspan'] }}" class="border border-gray-200 align-middle text-center bg-gray-100 py-3 px-4">
                                                {{ $value['pegawai'] }}<br>
                                                {{ $value['role'] }}<br>
                                            </td>
                                        @elseif ($value === 1)
                                            <td class="border-r border-t border-gray-200 py-3 px-4"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
        Menampilkan
        <span class="font-semibold text-gray-900 dark:text-white">
            @if ($users->count())
            {{ $users->firstItem() }}-{{ $users->lastItem() }}
            @else
            0-0
            @endif
        </span>
        dari
        <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
    </span>
    <div>
        {{ $users->links() }} <!-- Menampilkan link navigasi halaman -->
    </div>
</nav> --}}

</div>

</x-layout>
</x-app-layout>

