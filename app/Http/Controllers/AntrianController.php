<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Role;
use App\Models\User;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AntrianController extends Controller
{

    public function downloadPdf($id)
{
    $antrean = \App\Models\Antrian::with('polis')->findOrFail($id);
    $pdf = Pdf::loadView('antrean.detail_pdf', compact('antrean'));
    return $pdf->download('antrean-'.$antrean->nomor_antrian.'.pdf');
}
public function next($poli_id)
{
    // Ubah status yang sedang dilayani jadi selesai
    Antrian::where('poli_id', $poli_id)->where('status', 'dilayani')->update(['status' => 'selesai']);

    // Ambil antrean berikutnya dan jadikan dilayani
    $selanjutnya = Antrian::where('poli_id', $poli_id)
                    ->where('status', 'antri')
                    ->orderBy('created_at')
                    ->first();

    if ($selanjutnya) {
        $selanjutnya->update(['status' => 'dilayani']);
    }

    return redirect()->route('admin.antrean.control.index')->with('success', 'Status antrian diperbarui');
}

    public function controlIndex()
{
    $today = Carbon::today()->toDateString();
    $polis = Poli::with(['antrians' => function ($query) use ($today) {
        $query->whereIn('status', ['antri', 'dilayani', 'skip'])
              ->where('tanggal_kunjungan', $today)
              ->orderByRaw("FIELD(status, 'dilayani', 'antri')")
              ->orderBy('created_at');
    }])->get();

    return view('admin.antrean.control.index', compact('polis'));
}
public function controlSkip($poliId)
{
    $today = Carbon::today()->toDateString();
    $antrian = Antrian::where('poli_id', $poliId)
        ->where('tanggal_kunjungan', $today)
        ->where('status', 'dilayani')
        ->orderBy('created_at')
        ->first();

    if ($antrian) {
        $antrian->status = 'skip'; // atau 'dilewati'
        $antrian->save();
    }

    return redirect()->back()->with('success', 'Pasien berhasil dilewati.');
}
public function controlRestore($id)
{
    $antrian = Antrian::findOrFail($id);
    if ($antrian->status === 'skip') {
        $antrian->status = 'antri';
        $antrian->save();
    }
    return back()->with('success', 'Antrean dikembalikan ke daftar antrian.');
}

public function controlTangguhkan($id)
{
    $antrian = Antrian::findOrFail($id);
    if ($antrian->status === 'skip') {
        $antrian->status = 'ditangguhkan';
        $antrian->save();
    }
    return back()->with('success', 'Antrean ditangguhkan.');
}
public function index(Request $request)
{
    $polis = Poli::all();
    $search = $request->input('search');
    $poli_id = $request->input('poli_id');
    $tanggal = $request->input('tanggal') ?? Carbon::today()->toDateString();

    $antrian = Antrian::query()
        ->where(function ($query) {
            $query->where('status', 'not like', '%selesai%')
                  ->where('status', 'not like', '%ditangguhkan%');
        })
        ->where('tanggal_kunjungan', $tanggal)
        ->when($poli_id, function ($query, $poli_id) {
            return $query->where('poli_id', $poli_id);
        })
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nik_pasien', 'like', "%$search%")
                  ->orWhere('nama_pasien', 'like', "%$search%");
            });
        })
        ->paginate(10)
        ->appends($request->only('search', 'poli_id', 'tanggal'));

    return view('admin.antrean.index', compact('antrian', 'search', 'polis', 'poli_id', 'tanggal'));
}

public function riwayat(Request $request)
{
    $polis = Poli::all();
    $search = $request->input('search');
    $poli_id = $request->input('poli_id');
    $tanggal = $request->input('tanggal');

    $antrian = Antrian::query()
        ->whereIn('status', ['selesai', 'ditangguhkan'])
        ->when($poli_id, function ($query, $poli_id) {
            $query->where('poli_id', $poli_id);
        })
        ->when($tanggal, function ($query, $tanggal) {
            $query->where('tanggal_kunjungan', $tanggal);
        })
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%$search%")
                  ->orWhere('nik_pasien', 'like', "%$search%");
            });
        })
        ->latest()
        ->paginate(10)
        ->appends($request->only('search', 'poli_id', 'tanggal'));

    return view('admin.antrean.riwayat', compact('antrian', 'search', 'polis', 'poli_id', 'tanggal'));
}
    public function adminMonitoring()
{
    // Ambil semua poli beserta antrean yang belum selesai
    $polis = Poli::with(['antrians' => function ($query) {
        $query->whereIn('status', ['dilayani', 'antri'])
              ->orderByRaw("FIELD(status, 'dilayani', 'antri')")
              ->orderBy('created_at');
    }])->get();

    return view('admin.antrean.monitoring', [
        'polis' => $polis,
        'hideNavbar' => true, // << ini kuncinya bro
    ]);
}
public function adminMonitoringData()
{
    $polis = Poli::with(['antrians' => function ($query) {
        $query->whereIn('status', ['dilayani', 'antri'])
              ->orderByRaw("FIELD(status, 'dilayani', 'antri')")
              ->orderBy('created_at');
    }])->get();

    return response()->json(['polis' => $polis]);
}
public function antreanIndex(Request $request)
{
    $polis = Poli::all();
    $filter = $request->input('filter');
    $today = now()->toDateString();

    $antrianQuery = Antrian::where('tanggal_kunjungan', $today);
    if ($filter) {
        $antrianQuery->where('poli_id', $filter);
    }
    $antrian = $antrianQuery->get();

    // Tambahkan inisial dengan spasi ke setiap antrian
    foreach ($antrian as $item) {
        $item->inisial_nama = implode(' ', array_map(function($k) {
            return strtoupper(substr($k, 0, 1));
        }, explode(' ', $item->nama_pasien)));
    }
    $todayFormatted = Carbon::parse($today)->locale('id')->isoFormat('dddd, D MMMM YYYY');

    return view('antrean.index', compact('antrian', 'polis', 'filter', 'today', 'todayFormatted'));
}


    public function showDetail($id)
{
    $antrean = Antrian::with('polis')->findOrFail($id);
    return view('admin.antrean.show', compact('antrean'));
}
public function berandaDetail($id)
{
    $antrean = Antrian::with('polis')->findOrFail($id);

    return view('antrean.detail', compact('antrean'));
}



    public function registrasi()
{
    $polis = Poli::all();

    // Ambil user yang memiliki role 'dokter umum' atau 'dokter gigi'
    $users = User::role(['dokter umum', 'dokter gigi'])->get();

    $antrians = Antrian::all();

    return view('antrean.registrasi', compact('antrians', 'users', 'polis'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $polis = Poli::all();
        $antrians = Antrian::all();
        return view('admin.antrean.create', compact('antrians', 'polis'));
    }


    private function ambilInisial($nama_poli)
{
    $kata = explode(' ', strtolower($nama_poli)); // pisahkan kata
    $inisial = '';

    foreach ($kata as $k) {
        $inisial .= strtoupper(substr($k, 0, 1)); // ambil huruf pertama & kapital
    }

    return $inisial;
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::debug('masuk store user', [$request->all()]);

        $request->validate([
            'nik_pasien' => 'required|string|size:16',
            'nama_pasien' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:ditangguhkan,dilayani,selesai,antri',
            'pembayaran' => 'required|string|in:umum,bpjs,mwcnu',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',
            'polis_id' => 'required|exists:polis,id',
        ]);

        $polis = Poli::find($request->polis_id);
        $tanggal = $request->tanggal_kunjungan;

        $kode = '';
        $count = 0;

        if ($polis) {
    $kode = $this->ambilInisial($polis->nama_poli); // gunakan $this->
}
        Log::debug('Kode inisial untuk poli:', [$kode]);


        // Hitung jumlah antrean hari ini untuk jenis dokter terkait
        $count = Antrian::where('tanggal_kunjungan', $tanggal)
            ->whereHas('polis', function ($query) use ($polis) {
                $query->where('nama_poli', $polis->nama_poli);
            })->count();

        $nomor_antrian = $kode . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        $existing = Antrian::where('nomor_antrian', $nomor_antrian)
            ->where('tanggal_kunjungan', $tanggal)
            ->exists();
        if ($existing) {
            return redirect()->back()->with('error', 'Nomor antrian sudah digunakan. Silakan coba lagi.');
        }

        Log::debug('Nomor antrian yang dihasilkan:', [$nomor_antrian]);
        Antrian::create([
            'nik_pasien' => $request->nik_pasien,
            'nama_pasien' => $request->nama_pasien,
            'tanggal_kunjungan' => $tanggal,
            'alamat_pasien' => $request->alamat_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status' => $request->status,
            'pembayaran' => $request->pembayaran,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'keluhan' => $request->keluhan,
            'nomor_antrian' => $nomor_antrian,
            'poli_id' => $request->polis_id,
        ]);

        Log::debug('Antrean berhasil ditambahkan');

      return redirect()->route('admin.antrian.index')->with('success', 'Antrean berhasil ditambahkan.');
    }

    public function registrasiStore(Request $request)
    {
        Log::debug('masuk store user', [$request->all()]);

        $request->validate([
            'nik_pasien' => 'required|string|size:16',
            'nama_pasien' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today|before_or_equal:' . \Carbon\Carbon::today()->addWeek()->format('Y-m-d'),
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'pembayaran' => 'required|string|in:umum,bpjs,mwcnu',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',
            'polis_id' => 'required|exists:polis,id',
            'cf-turnstile-response' => 'required',
        ]);

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
    'secret' => '0x4AAAAAABkhqXT6UOYcb2o6R-hRnpEEpto', // Ganti dengan Secret Key kamu
    'response' => $request->input('cf-turnstile-response'),
    'remoteip' => $request->ip(),
]);

if (!optional($response->object())->success) {
    return redirect()->back()->withErrors(['turnstile' => 'Verifikasi captcha gagal. Silakan coba lagi.'])->withInput();
}

        $polis = Poli::find($request->polis_id);
        $tanggal = $request->tanggal_kunjungan;

        $kode = '';
        $count = 0;

        if ($polis) {
    $kode = $this->ambilInisial($polis->nama_poli); // gunakan $this->
}
        Log::debug('Kode inisial untuk poli:', [$kode]);


        // Hitung jumlah antrean hari ini untuk jenis dokter terkait
        $count = Antrian::where('tanggal_kunjungan', $tanggal)
            ->whereHas('polis', function ($query) use ($polis) {
                $query->where('nama_poli', $polis->nama_poli);
            })->count();

        $nomor_antrian = $kode . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        $existing = Antrian::where('nomor_antrian', $nomor_antrian)
            ->where('tanggal_kunjungan', $tanggal)
            ->exists();
        if ($existing) {
            return redirect()->back()->with('error', 'Nomor antrian sudah digunakan. Silakan coba lagi.');
        }

        Log::debug('Nomor antrian yang dihasilkan:', [$nomor_antrian]);
        $antrian = Antrian::create([
    'nik_pasien' => $request->nik_pasien,
    'nama_pasien' => $request->nama_pasien,
    'tanggal_kunjungan' => $tanggal,
    'alamat_pasien' => $request->alamat_pasien,
    'jenis_kelamin' => $request->jenis_kelamin,
    'tanggal_lahir' => $request->tanggal_lahir,
    'status' => 'antri',
    'pembayaran' => $request->pembayaran,
    'nomor_whatsapp' => $request->nomor_whatsapp,
    'keluhan' => $request->keluhan,
    'nomor_antrian' => $nomor_antrian,
    'poli_id' => $request->polis_id,
]);

return redirect()->route('antrean.detail', $antrian->id)
    ->with('success', 'Pendaftaran berhasil. Berikut detail antrean Anda.');
    }

    public function edit($id)
    {

        $antrians = Antrian::findOrFail($id);
        return view('admin.antrean.edit', compact('antrians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nik_pasien' => 'required|string|size:16',
            'nama_pasien' => 'required|string|max:255',
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:ditangguhkan,dilayani,selesai,antri',
            'pembayaran' => 'required|string|in:umum,bpjs,mwcnu',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',

        ]);

        $antrian = Antrian::findOrFail($id);
        $antrian->update($validatedData);

        return redirect()->route('admin.antrian.index')->with('success', 'Pasien berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        $Antrians = Antrian::findOrFail($id);
        $Antrians->delete();
        return redirect()->route('admin.antrian.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
