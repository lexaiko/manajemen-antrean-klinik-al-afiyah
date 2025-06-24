<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JadwalPegawai;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class JadwalPegawaiController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $roleFilter = $request->input('role');

        $urutanHari = config('app.urutan');
        $urutanHariString = "'" . implode("','", $urutanHari) . "'";

        $jadwals = JadwalPegawai::with('pegawai.roles') // load pegawai + roles
            ->when($roleFilter, function ($query) use ($roleFilter) {
                $userIds = User::role($roleFilter)->pluck('id');
                $query->whereIn('pegawai_id', $userIds);
            })
            ->orderByRaw("FIELD(hari, $urutanHariString)")
            ->get();

        return view('admin.jadwal.index', compact('jadwals', 'roles', 'roleFilter', 'urutanHari'));
    }

    public function jadwalBeranda(Request $request)
    {
        $roles = Role::where('name', '!=', 'admin klinik')->get();
        $roleAlias = $request->input('role');
        $selectedRole = $roles->firstWhere('name', $roleAlias);

        $urutanHari = config('app.urutan');
        $urutanHariString = "'" . implode("','", $urutanHari) . "'";

        $jadwals = JadwalPegawai::with('pegawai.roles')
            ->when($roleAlias, function ($query) use ($roleAlias) {
                $userIds = User::role($roleAlias)->pluck('id');
                $query->whereIn('pegawai_id', $userIds);
            })
            ->orderByRaw("FIELD(hari, $urutanHariString)")
            ->get();

        return view('jadwal.index', compact('jadwals', 'roles', 'roleAlias', 'selectedRole', 'urutanHari'));
    }

    public function create()
    {
        $tenaga_medis = User::with('roles')->get();
        $kategoris = Role::all();
        return view('admin.jadwal.create', compact('tenaga_medis', 'kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalPegawai::create($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pegawai berhasil ditambahkan.');
    }

    public function show(JadwalPegawai $jadwalTenagaMedis)
    {
        return view('admin.jadwal.show', compact('jadwalTenagaMedis'));
    }

    public function edit($id)
{
    $tenagaMedis = User::with('roles')->get();
    $jadwal = JadwalPegawai::findOrFail($id);

    return view('admin.jadwal.edit', compact('jadwal', 'tenagaMedis'));
}


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i|after_or_equal:07:00|before:14:00',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai|before_or_equal:21:00',
        ]);

        $jadwal = JadwalPegawai::findOrFail($id);
        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPegawai::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pegawai berhasil dihapus.');
    }
}
