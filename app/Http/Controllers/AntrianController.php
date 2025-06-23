<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Antrian;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Poli;

class AntrianController extends Controller
{
    public function index(Request $request)
    {
        $polis = Poli::all();
        $search = $request->input('search');
        $antrian = Antrian::where('status', '!=', 'selesai')->paginate(10);
        $searchNik = $request->input('search_nik');

        if ($searchNik) {
            $antrian = Antrian::where('nik_pasien', $searchNik)->latest()->paginate(10);
            return view('admin.antrean.index', compact('antrian', 'searchNik', 'polis'));
        }


        return view('admin.antrean.index', compact('antrian', 'search', 'polis'));
    }
    public function riwayat(Request $request)
    {
        $polis = Poli::all();
        $filter = $request->input('filter'); // dokter_umum, dokter_gigi, null
        $search = $request->input('search');

        $antrian = Antrian::query()
            ->when($filter === 'poli_umum', function ($query) {
                return $query->where('nomor_antrian', 'like', 'DU%');
            })
            ->when($filter === 'poli_gigi', function ($query) {
                return $query->where('nomor_antrian', 'like', 'DG%');
            })
            ->when($filter === 'poli_kia', function ($query) {
                return $query->where('nomor_antrian', 'like', 'KIA%');
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama_pasien', 'like', "%{$search}%")
                        ->orWhere('nik_pasien', 'like', "%{$search}%");
                });
            })
            ->paginate(10);
        $searchNik = $request->input('search_nik');

        if ($searchNik) {
            $antrian = Antrian::where('nik_pasien', $searchNik)->latest()->paginate(10);
            return view('admin.antrean.riwayat', compact('antrian', 'searchNik', 'filter', 'polis'));
        }


        return view('admin.antrean.riwayat', compact('antrian', 'search', 'filter', 'polis'));
    }
    public function monitoring()
    {
        $dilayani = Antrian::where('status', 'dilayani')->first();

        $dilayani_du = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'DU%')
            ->first();
        $dilayani_dg = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'DG%')
            ->first();
        $dilayani_kia = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'KIA%')
            ->first();
        $duberikutnya = null;
        if ($dilayani_du || null) {
            $duberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_du->nomor_antrian)
                ->where('nomor_antrian', 'like', 'DU%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        $dgberikutnya = null;
        if ($dilayani_dg || null) {
            $dgberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_dg->nomor_antrian)
                ->where('nomor_antrian', 'like', 'DG%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        $kiaberikutnya = null;
        if ($dilayani_dg || null) {
            $kiaberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_kia->nomor_antrian)
                ->where('nomor_antrian', 'like', 'KIA%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        return view('monitoring', compact('dilayani_du', 'dilayani_dg', 'dilayani_kia', 'dgberikutnya', 'duberikutnya', 'kiaberikutnya'));
    }
    public function adminmonitoring()
    {
        $dilayani = Antrian::where('status', 'dilayani')->first();

        $dilayani_du = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'DU%')
            ->first();
        $dilayani_dg = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'DG%')
            ->first();
        $dilayani_kia = Antrian::where('status', 'dilayani')
            ->where('nomor_antrian', 'like', 'KIA%')
            ->first();
        $duberikutnya = null;
        if ($dilayani_du || null) {
            $duberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_du->nomor_antrian)
                ->where('nomor_antrian', 'like', 'DU%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        $dgberikutnya = null;
        if ($dilayani_dg || null) {
            $dgberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_dg->nomor_antrian)
                ->where('nomor_antrian', 'like', 'DG%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        $kiaberikutnya = null;
        if ($dilayani_kia || null) {
            $kiaberikutnya = Antrian::where('nomor_antrian', '>', $dilayani_kia->nomor_antrian)
                ->where('nomor_antrian', 'like', 'KIA%')
                ->orderBy('nomor_antrian', 'asc')
                ->first();
        }
        return view('admin.antrean.monitoring', compact('dilayani_du', 'dilayani_dg', 'dilayani_kia', 'duberikutnya', 'dgberikutnya', 'kiaberikutnya'));
    }

    public function monitoringlengkap(Request $request)
    {
        $polis = Poli::all(); // Ganti dari User::all() ke Poli::all()
        $filter = $request->input('filter'); // dokter_umum, dokter_gigi, null

        $antrian = Antrian::query()
            ->when($filter === 'poli_umum', function ($query) {
                return $query->where('nomor_antrian', 'like', 'DU%');
            })
            ->when($filter === 'poli_gigi', function ($query) {
                return $query->where('nomor_antrian', 'like', 'DG%');
            })
            ->when($filter === 'poli_kia', function ($query) {
                return $query->where('nomor_antrian', 'like', 'KIA%');
            })
            ->get();

        Log::debug('Filter: ' . $filter, ['antrian' => $antrian]);

        return view('antreanlengkap', compact('antrian', 'polis', 'filter'));
    }


    public function detail()
    {
        $antrian = Antrian::paginate(11);
        return view('admin.antrean.detail', compact('antrian'));
    }

    public function welcome()
    {
        $polis = Poli::all();
        $users = User::whereHas('role', function ($q) {
            $q->whereIn('nama_role', ['dokter umum', 'dokter gigi']);
        })->with('role')->get();


        $antrians = Antrian::all();
        return view('welcome', compact('antrians', 'users', 'polis'));
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::debug('masuk store user', [$request->all()]);

        $request->validate([
            'nik_pasien' => 'required|string|size:16|unique:antrians,nik_pasien|regex:/^3502[0-9]{12}$/',
            'nama_pasien' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:ditangguhkan,dilayani,selesai,antri',
            'pembayaran' => 'required|string|in:umum,bpjs',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',
            'polis_id' => 'required|exists:polis,id',
        ]);

        $polis = Poli::find($request->polis_id);
        $tanggal = $request->tanggal_kunjungan;

        $kode = '';
        $count = 0;

        if ($polis) {
            if ($polis->nama_poli === 'umum') {
                $kode = 'DU';
            } elseif ($polis->nama_poli === 'gigi') {
                $kode = 'DG';
            } elseif ($polis->nama_poli === 'kia') {
                $kode = 'KIA';
            }
        }

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

        if ($request->route()->getName() === 'welcome.store') {
            return redirect()->route('monitoring')->with('success', 'Antrean berhasil ditambahkan.');
        } elseif ($request->route()->getName() === 'admin.antrian.store') {
            return redirect()->route('admin.antrian')->with('success', 'Antrean berhasil ditambahkan.');
        }
        Log::debug('masuk store user', [$request->all()]);
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
            'nik_pasien' => 'required|string|size:16|regex:/^3502[0-9]{12}$/',
            'nama_pasien' => 'required|string|max:255',
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:ditangguhkan,dilayani,selesai,antri',
            'pembayaran' => 'required|string|in:umum,bpjs',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',

        ]);

        $antrian = Antrian::findOrFail($id);
        $antrian->update($validatedData);

        return redirect()->route('admin.antrian')->with('success', 'Pegawai berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        $Antrians = Antrian::findOrFail($id);
        $Antrians->delete();
        return redirect()->route('admin.antrian')->with('success', 'Pegawai berhasil dihapus.');
    }
}
