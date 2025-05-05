<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TenagaMedis;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class TenagaMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($jenis = null)
{
    $query = TenagaMedis::with('user'); // kalau kamu pakai relasi user

    if ($jenis) {
        $query->where('jenis_tenaga', $jenis); // filter berdasarkan jenis tenaga medis
    }

    $tenagaMedis = $query->paginate(5);

    return view('admin.tenagamedis.index', compact('tenagaMedis', 'jenis'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'pasien')->get();
        return view('admin.tenagamedis.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|unique:tenaga_medis|max:20',
            'jenis_tenaga' => 'required|string|max:10',
            'spesialisasi' => 'nullable|string|max:100',
        ]);

        TenagaMedis::create([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'jenis_tenaga' => $request->jenis_tenaga,
            'spesialisasi' => $request->spesialisasi,
        ]);

        return redirect()->route('admin.tenagamedis.index')->with('success', 'tenagamedis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tenagaMedis = TenagaMedis::findOrFail($id);
        return view('admin.tenagamedis.edit', compact('tenagaMedis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:20|unique:tenaga_medis,nip,',
            'jenis_tenaga' => 'required|string|max:10',
            'spesialisasi' => 'nullable|string|max:100',
        ]);

        $tenagamedis = TenagaMedis::findOrFail($id);
        $tenagamedis->update($validatedData);

        return redirect()->route('admin.tenagamedis.index')->with('success', 'tenagamedis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tenagamedis = TenagaMedis::findOrFail($id);
        $tenagamedis->delete();
        return redirect()->route('admin.tenagamedis.index')->with('success', 'tenagamedis berhasil dihapus.');
    }
}

