<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Antrian;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    public function index(Request $request)
    {
        $query = Antrian::query();

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where('nama_pasien', 'like', "%{$search}%")
                ->orWhere('nik_pasien', 'like', "%{$search}%");
        }
        $antrian = $query->get();
        $antrian = Antrian::paginate(11);
        return view('admin.antrean.index', compact('antrian'));
    }
    public function monitoring()
    {

        return view('admin.antrean.monitoring');
    }
    public function detail()
    {
        $antrian = Antrian::paginate(11);
        return view('admin.antrean.detail', compact('antrian'));
    }

    public function welcome()
    {
        $users = User::whereHas('role', function ($q) {
            $q->whereIn('nama_role', ['dokter umum', 'dokter gigi']);
        })->with('role')->get();


        $antrians = Antrian::all();
        return view('welcome', compact('antrians', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('role', function ($q) {
            $q->whereIn('nama_role', ['dokter umum', 'dokter gigi']);
        })->with('role')->get();


        $antrians = Antrian::all();
        return view('admin.antrean.create', compact('antrians', 'users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::debug('masuk store user', [$request->all()]);

        $request->validate([
            'nik_pasien' => 'required|string|size:16|regex:/^3502[0-9]{12}$/',
            'nama_pasien' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'alamat_pasien' => 'required|string',
            'jenis_kelamin' => 'required|string|in:L,P|max:1',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:ditangguhkan,dilayani,selesai,antri',
            'pembayaran' => 'required|string|in:umum,bpjs',
            'nomor_whatsapp' => 'required|string|min:10|max:15',
            'keluhan' => 'required|string|max:255',
            'pegawais_id' => 'required|exists:users,id',
        ]);



        $dokterId = $request->input('pegawais_id');
        $dokter = User::with('role')->find($dokterId);
        $tanggal = $request->tanggal_kunjungan;

        $kode = '';
        $count = 0;

        if ($dokter && $dokter->role) {
            if ($dokter->role->nama_role === 'dokter umum') {
                $kode = 'DU';
            } elseif ($dokter->role->nama_role === 'dokter gigi') {
                $kode = 'DG';
            }
        }

        // Hitung jumlah antrean hari ini untuk jenis dokter terkait
        $count = Antrian::where('tanggal_kunjungan', $tanggal)
            ->whereHas('pegawais.role', function ($query) use ($dokter) {
                $query->where('nama_role', $dokter->role->nama_role);
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
            'pegawais_id' => $request->pegawais_id ?? null,

        ]);

        Log::debug('Antrean berhasil ditambahkan');

        if ($request->route('/')) {
            return redirect('admin.antrean.monitoring')->with('success', 'Antrean berhasil ditambahkan.');
        } else if ($request->route('admin/antrean/create')) {
            return redirect('admin.antrean.index')->with('success', 'Antrean berhasil ditambahkan.');
        }
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
