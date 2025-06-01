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
    public function index()
    {
        $jadwals = JadwalPegawai::paginate(5);
        return view('admin.jadwal.index', compact('jadwals'));
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
        $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i|after_or_equal:08:00|before:18:00',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai|before_or_equal:18:00',
        ]);

        JadwalPegawai::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Tenaga Medis created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalPegawai  $jadwalTenagaMedis
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
        $jadwal = jadwalTenagaMedis::findOrFail($id);
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
            'jam_mulai' => 'required|date_format:H:i|after_or_equal:08:00|before:18:00',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai|before_or_equal:18:00',
        ]);

        $jadwalTenagaMedis = JadwalPegawai::findOrFail($id);
        $jadwalTenagaMedis->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Tenaga Medis updated successfully');
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

