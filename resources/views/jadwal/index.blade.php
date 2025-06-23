@extends('layouts.main')

@section('content')
    @include('partials.navbar')
    <div class="max-w-6xl mx-auto py-10 px-4 md:mt-0 mt-16">
        <h2 class="text-2xl font-bold mb-6">
            Jadwal {{ $selectedRole?->nama_role ?? 'Semua Jadwal' }}
        </h2>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            {{-- Filter Role --}}
            <form method="GET" action="{{ route('jadwal.index') }}" class="w-full md:w-auto max-w-md">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">
                    Filter Pegawai
                </label>
                <div class="relative">
                    <select id="role" name="role" onchange="this.form.submit()"
                        class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                    focus:border-blue-500 block w-full p-2.5 pr-10">
                        <option value="">Semua Jadwal</option>
                        @foreach ($roles as $role)
                            <option value="{{ strtolower($role->nama_role) }}"
                                {{ strtolower($roleAlias) === strtolower($role->nama_role) ? 'selected' : '' }}>
                                {{ $role->nama_role }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Icon panah -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        {{-- Mobile View --}}
        <div class="md:hidden space-y-6">
            @if ($jadwals->isEmpty())
                <div
                    class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-md">
                    <p>⚠️ Tidak ada jadwal ditemukan untuk role ini.</p>
                </div>
            @else
                @foreach ($urutanHari as $hari)
                    @php
                        $jadwalHari = $jadwals->where('hari', $hari);
                    @endphp

                    <div class="{{ $jadwalHari->isNotEmpty() ? '' : 'hidden' }}">
                        <h2 class="text-lg font-bold text-blue-600 mb-2">🗓️ {{ $hari }}</h2>

                        @if ($jadwalHari->isNotEmpty())
                            @foreach ($jadwalHari as $jadwal)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow p-4 mb-3">
                                    <div class="font-medium text-gray-900">
                                        👨‍⚕️ {{ $jadwal->pegawai->name }} ({{ $jadwal->role->nama_role }})
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        ⏰ {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div
                                class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-md">
                                <p>⚠️ Tidak ada jadwal untuk di hari ini.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>



        <div class="hidden md:block mt-10 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">No</th>
                        <th scope="col" class="px-4 py-3">Nama Pegawai</th>
                        <th scope="col" class="px-4 py-3">Profesi</th>
                        <th scope="col" class="px-4 py-3">Hari</th>
                        <th scope="col" class="px-4 py-3">Jam Mulai</th>
                        <th scope="col" class="px-4 py-3">Jam Selesai</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwals as $jadwal)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $jadwal->pegawai->name }}</td>
                            <td class="px-4 py-3">{{ $jadwal->role->nama_role }}</td>
                            <td class="px-4 py-3">{{ $jadwal->hari }}</td>
                            <td class="px-4 py-3">{{ $jadwal->jam_mulai }}</td>
                            <td class="px-4 py-3">{{ $jadwal->jam_selesai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data jadwal</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
@endsection
