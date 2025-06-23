<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;
use Illuminate\Support\Facades\Log;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::paginate(10);

        return view('admin.poli.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
        ]);

        Log::debug('Masuk store poli', $request->all());

        Poli::create($request->all());

        return redirect()->route('admin.poli')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.poli.edit', compact('poli'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_poli' => 'required|unique:polis,nama_poli,' . $id, // Ignore current ID
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($request->all());

        return redirect()->route('admin.poli')->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();
        return redirect()->route('admin.poli')->with('success', 'Poli berhasil dihapus.');
    }
}
