<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\JadwalPegawai;

class JadwalPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $roles = Role::all();
    $roleId = $request->input('role_id');

    $urutanHari = config('app.urutan');
    $urutanHariString = "'" . implode("','", $urutanHari) . "'";

    $jadwals = JadwalPegawai::with(['pegawai', 'role'])
        ->when($roleId, fn($q) => $q->where('role_id', $roleId))
        ->orderByRaw("FIELD(hari, $urutanHariString)")
        ->get();

    return view('admin.jadwal.index', compact('jadwals', 'roles', 'roleId', 'urutanHari'));
}

public function jadwalBeranda(Request $request)
{
    // Ambil semua role kecuali Admin
    $roles = Role::where('nama_role', 'NOT LIKE', 'Admin%')->get();

    // Ambil alias dari query string (?role=dokter)
    $roleAlias = $request->input('role');
    $roleId = null;

    if ($roleAlias) {
        // Temukan ID berdasarkan nama_role (case insensitive)
        $matchedRole = $roles->firstWhere('nama_role', ucfirst(strtolower($roleAlias)));
        $roleId = $matchedRole?->id;
    }

    // Urutan hari untuk pengurutan jadwal
    $urutanHari = config('app.urutan');
    $urutanHariString = "'" . implode("','", $urutanHari) . "'";

    $jadwals = JadwalPegawai::with(['pegawai', 'role'])
        ->whereHas('role', fn($q) => $q->where('nama_role', '!=', 'Admin'))
        ->when($roleId, fn($q) => $q->where('role_id', $roleId))
        ->orderByRaw("FIELD(hari, $urutanHariString)")
        ->get();

    return view('jadwal.index', compact('jadwals', 'roles', 'roleAlias', 'urutanHari'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tenaga_medis = User::all();
        $kategoris = Role::all();
        return view('admin.jadwal.create', compact('tenaga_medis', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'pegawai_id' => 'required|exists:users,id',
        'hari' => 'required',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ]);

    // Ambil role_id berdasarkan pegawai
    $pegawai = User::findOrFail($validated['pegawai_id']);

    JadwalPegawai::create([
        'pegawai_id' => $pegawai->id,
        'role_id' => $pegawai->role_id, // ⬅️ otomatis diambil
        'hari' => $validated['hari'],
        'jam_mulai' => $validated['jam_mulai'],
        'jam_selesai' => $validated['jam_selesai'],
    ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pegawai created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalPegawai  $jadwalPegawai
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalPegawai $jadwalTenagaMedis)
    {
        return view('admin.jadwal.show', compact('jadwalTenagaMedis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalPegawai  $jadwalTenagaMedis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenagaMedis = User::all();
        $kategori = Role::all();
        $jadwal = jadwalPegawai::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal', 'tenagaMedis', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalPegawai  $jadwalTenagaMedis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i|after_or_equal:07:00|before:14:00',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai|before_or_equal:21:00',
        ]);

        $jadwalTenagaMedis = JadwalPegawai::findOrFail($id);
        $jadwalTenagaMedis->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'jadwal pegawai berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalPegawai  $jadwalTenagaMedis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalTenagaMedis = JadwalPegawai::findOrFail($id);
        $jadwalTenagaMedis->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Tenaga Medis deleted successfully');
    }
}
