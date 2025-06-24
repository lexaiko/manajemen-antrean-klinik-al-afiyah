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
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" fill="none" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 9l4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Edit Peran</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Judul -->
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Edit Peran</h1>

        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="mb-4 text-sm text-green-800 bg-green-100 rounded-lg p-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tampilkan error validasi -->
        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form edit role -->
        <form action="{{ route('admin.role.update', $role->id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 max-w-xl">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Role</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('name', $role->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Update
            </button>
        </form>
    </x-layout>
</x-app-layout>
