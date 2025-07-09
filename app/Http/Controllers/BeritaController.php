<?php

namespace App\Http\Controllers;

use HTMLPurifier;
use HTMLPurifier_Config;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $beritas = Berita::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('judul', 'like', "%$query%");
        })->paginate(5);

        return view('admin.berita.index', compact('beritas', 'query'));
    }

    public function create()
    {
        $currentDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $namaPublished = Auth::user()->name;

        return view('admin.berita.create', [
            'currentDate' => $currentDate,
            'namaPublished' => $namaPublished
        ]);
    }
    public function beranda()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('beritas'));
    }

    public function showBeranda($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('berita.detail', compact('berita'));
    }
    public function indexBeranda()
    {
        $beritas = Berita::orderBy('tgl_published', 'desc')->paginate(5);
        return view('berita.index', compact('beritas'));
    }

    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string|max:4294967295',
            'tgl_published' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:11048',
        ]);

        $namaPublished = Auth::user()->name; // Ambil nama user yang login
        Log::info('User published:', ['name' => $namaPublished]);

        $daysInIndonesian = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday'
        ];

        $monthsInIndonesian = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $tgl_published = $request->tgl_published;

        foreach ($daysInIndonesian as $indonesian => $english) {
            if (strpos($tgl_published, $indonesian) !== false) {
                $tgl_published = str_replace($indonesian, $english, $tgl_published);
                break;
            }
        }

        foreach ($monthsInIndonesian as $indonesian => $english) {
            if (strpos($tgl_published, $indonesian) !== false) {
                $tgl_published = str_replace($indonesian, $english, $tgl_published);
                break;
            }
        }

        Log::info('Converted date:', ['original' => $request->tgl_published, 'converted' => $tgl_published]);

        try {
            $tgl_published = Carbon::createFromFormat('l, d F Y', $tgl_published)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Date format error:', ['message' => $e->getMessage()]);
            return back()->withErrors(['tgl_published' => 'Format tanggal tidak valid'])->withInput();
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'berita/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($file));

            Log::info('Image uploaded:', ['path' => $path, 'filename' => $filename]);
        } else {
            Log::warning('No image uploaded');
            return back()->withErrors(['gambar' => 'Gambar harus diunggah'])->withInput();
        }


        $berita = new Berita;
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,i,u,strong,em,ul,ol,li,a[href|title|target],img[src|alt|width|height|style],br,span[style],h1,h2,h3,h4,h5,h6,blockquote');

        $purifier = new HTMLPurifier($config);
        $kontenAman = $purifier->purify($request->input('konten'));

        $berita->konten = $kontenAman;

        $berita->judul = $request->input('judul');
        $berita->tgl_published = $tgl_published;
        $berita->nama_published = $namaPublished;
        $berita->gambar = $path;

// Simpan dulu agar dapat ID
$berita->save();
Log::info('Berita saved:', ['judul' => $berita->judul, 'id' => $berita->id]);
// Sekarang buat slug dengan ID yang sudah ada
$berita->slug = Str::slug($berita->judul) . '-' . now()->format('Ymd') . '-' . $berita->id;
$berita->save();

        Log::info('Berita slug updated:', ['slug' => $berita->slug]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

   public function update(Request $request, Berita $berita)
{
    $request->validate([
        'judul' => 'required|string',
        'konten' => 'required|string|max:4294967295',
        'tgl_published' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
    ]);

    $tgl_published = $request->input('tgl_published');

    // Validasi dan format ulang tanggal
    try {
        $tgl_published = Carbon::createFromFormat('Y-m-d', $tgl_published)->format('Y-m-d');
    } catch (\Exception $e) {
        return back()->withErrors(['tgl_published' => 'Format tanggal tidak valid'])->withInput();
    }

    // Default path adalah gambar lama
    $path = $berita->gambar;

    // Jika ada file baru diunggah
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('berita', $file, $filename);

        // Hapus gambar lama jika ada
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        Log::info('Gambar baru diunggah:', ['filename' => $filename]);
    }

    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,b,i,u,strong,em,ul,ol,li,a[href|title|target],img[src|alt|width|height|style],br,span[style],h1,h2,h3,h4,h5,h6,blockquote');

    $purifier = new HTMLPurifier($config);
    $kontenAman = $purifier->purify($request->input('konten'));

    // Update data
    $berita->update([
        'judul' => $request->input('judul'),
        'konten' => $kontenAman,
        'tgl_published' => $tgl_published,
        'nama_published' => Auth::user()->name,
        'gambar' => $path,
    ]);
    Log::info('Konten sebelum disanitasi:', ['konten' => $request->input('konten')]);
    Log::info('Konten sesudah disanitasi:', ['konten' => $kontenAman]);

    Log::info('Berita diperbarui:', ['id' => $berita->id]);

    return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
}


    public function destroy(Berita $berita)
    {
        $filePath = public_path('upload/berita/' . $berita->gambar);

        if (file_exists($filePath) && !is_dir($filePath)) {
            unlink($filePath);
        } else {
            // dd('File does not exist or is a directory: ' . $filePath);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $beritas = Berita::where('judul', 'like', "%$query%")
            ->paginate(10);

        return view('admin.berita.index', compact('beritas', 'query'));
    }

    public function uploadImageSummernote(Request $request, $type)
    {
        $post = $request->all();
        $post['type'] = 'summernote';

        // Validasi ukuran file (maksimum 5MB)
        $size = $request->file->getSize();
        if ($size > 10000000) {
            return ['status' => false, 'messages' => ['Image Size Exceeded 10MB']];
        }

        // Tentukan ekstensi dan nama file
        $ext = $request->file->getClientOriginalExtension();
        $filename = 'summernote_image_' . time() . '.' . $ext;
        $path = 'upload/' . $filename;

        // Pindahkan file ke direktori public/upload
        $request->file->move(public_path('upload'), $filename);

        // Cek apakah file berhasil disimpan
        if (file_exists(public_path($path))) {
            return [
                "status" => "success",
                "path" => $path,
                "image" => $filename,
                "image_url" => url($path)
            ];
        } else {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteImageSummernote(Request $request, $type)
    {
        // Pastikan 'target' ada di request
        if (!$request->has('target')) {
            return response()->json(['status' => false, 'message' => 'Target tidak ditemukan'], 400);
        }

        // Memisahkan URL dan mengambil nama file dari 'target'
        $arrayUrl = array_filter(explode('/', $request->target));
        $fileName = end($arrayUrl);
        $path = public_path('upload/' . $fileName);

        // Cek apakah file ada dan hapus
        if (file_exists($path)) {
            unlink($path); // Menghapus file

            return response()->json(['status' => true, 'message' => 'Gambar berhasil dihapus']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gambar tidak ditemukan'], 404);
        }
    }
}
