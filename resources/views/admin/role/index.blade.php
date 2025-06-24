<x-app-layout>
    <x-layout>

        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.role.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Peran
                    </a>
                </li>
            </ol>
        </nav>

        <!-- Judul -->
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Daftar Role</h1>

        <!-- Tombol Tambah -->
        <a href="{{ route('admin.role.create') }}"
            class="mb-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-700 transition">
            + Tambah Role
        </a>

        <!-- Notifikasi sukses -->
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Role</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $loop->iteration + ($roles->firstItem() - 1) }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.role.edit', $role->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus role ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                Tidak ada data role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $roles->links() }}
        </div>

    </x-layout>
</x-app-layout>
