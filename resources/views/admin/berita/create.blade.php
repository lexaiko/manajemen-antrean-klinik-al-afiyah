<x-app-layout>
    <x-layout>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-3 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.berita.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Berita
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Tambah
                            Berita</a>
                    </div>
                </li>
            </ol>
        </nav>
        <h2 class="mb-4 py-2 text-3xl font-bold text-gray-900 dark:text-white">Tambah Berita</h2>
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        <!-- Tampilkan pesan error jika ada -->
        @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('admin.berita.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-2 sm:grid-cols-2 sm:gap-2">
                <div class="sm:col-span-1">
                    <label for="judul"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                    <input type="text" name="judul" id="judul" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="">
                </div>
                <div class="w-full" style="display: none;">
                    <label for="tgl_published"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Publish</label>
                    <input type="hidden" name="tgl_published" id="tgl_published"
                        value="{{ old('tgl_published', $currentDate) }}">
                </div>

                <div class="w-full" style="display: none;">
                    <label for="nama_published"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Published</label>
                    <input type="hidden" name="nama_published" id="nama_published"
                        value="
                        {{ $namaPublished }}
                        ">
                </div>
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
                        Gambar</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="gambar" name="gambar" type="file" required>
                </div>
            </div>
            <div class="grid gap-2 sm:grid-cols-1 sm:gap-2">
                <div class="w-full">
                    <label for="konten"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konten</label>
                    <textarea name="konten" id="summernote"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        style="min-width: 100%; max-width: 100%;"></textarea>
                </div>
            </div>
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-green-200 dark:focus:ring-green-700 hover:bg-green-700">
                Tambah Artikel
            </button>
        </form>
        <script>
            const summerNoteInit = () => {
                $('#summernote').summernote({
                    lang: 'en-US',
                    imageAttributes: {
                        icon: '<i class="note-icon-pencil"/>',
                        removeEmpty: false, // true = remove attributes | false = leave empty if present
                        disableUpload: false // true = don't display Upload Options | Display Upload Options
                    },
                    popover: {
                        image: [
                            ['custom', ['imageAttributes']],
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                    },
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['style', 'ul', 'ol', 'paragraph', 'height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video', 'hr', 'grid']],
                        ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
                    ],
                    grid: {
                        wrapper: "row",
                        columns: [
                            "col-md-12",
                            "col-md-6",
                            "col-md-4",
                            "col-md-3",
                            "col-md-24",
                        ]
                    },
                    callbacks: {
                        onImageUpload: function(image) {
                            sendFile(image[0]);
                        },
                        onMediaDelete: function(target) {
                            deleteFile(target[0].src);
                        }
                    },
                    icons: {
                        grid: "bi bi-grid-3x2"
                    },
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                // $('#summernote').summernote();
                summerNoteInit();
            });

            function sendFile(file, editor, welEditable) {
                token = "{{ csrf_token() }}"
                data = new FormData();
                data.append("file", file);
                data.append('_token', token);
                $('#loading-image-summernote').show();
                $('#summernote').summernote('disable');
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "{{ url('summernote/picture/upload/article') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(url) {
                        console.log(url);
                        if (url['status'] == "success") {
                            $('#summernote').summernote('enable');
                            $('#loading-image-summernote').hide();
                            $('#summernote').summernote('editor.saveRange');
                            $('#summernote').summernote('editor.restoreRange');
                            $('#summernote').summernote('editor.focus');
                            $('#summernote').summernote('editor.insertImage', url['image_url']);
                        }
                        $("img").addClass("img-fluid");
                    },
                    error: function(data) {
                        console.log(data)
                        $('#summernote').summernote('enable');
                        $('#loading-image-summernote').hide();
                    }
                });
            }

            function deleteFile(target) {
                token = "{{ csrf_token() }}"
                data = new FormData();
                data.append("target", target);
                data.append('_token', token);
                $('#loading-image-summernote').show();
                $('.summernote').summernote('disable');
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "{{ url('summernote/picture/delete/article') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        console.log(result)
                        if (result['status'] == "success") {
                            $('.summernote').summernote('enable');
                            $('#loading-image-summernote').hide();
                        }
                    },
                    error: function(data) {
                        console.log(data)
                        $('.summernote').summernote('enable');
                        $('#loading-image-summernote').hide();
                    }
                });
            }
        </script>
    </x-layout>
</x-app-layout>
