<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Antrian::paginate(5);
        return view('admin.antrean.index', compact('antrian'));
    }
    public function monitoring(){
        $antrian = Antrian::all();
        return view('admin.antrean.monitoring',compact('antrian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
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
            'status' => 'nullable|string|in:ditangguhkan,diperiksa,selesai',
            'pembayaran' => 'nullable|string|in:reguler,bpjs',
        ]);

        Antrian::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'role_id' => $request->role_id ?? null,
        ]);

        Log::debug('Pegawai berhasil ditambahkan');

        return redirect()->route('admin.antrean.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }
}
