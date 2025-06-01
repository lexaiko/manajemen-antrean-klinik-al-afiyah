<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoriJadwals = Role::paginate(5);
        return view('admin.role.index', compact('kategoriJadwals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
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
            'nama_role' => 'required|unique:roles|max:255',
        ]);

        \Log::debug('masuk store role', [$request->all()]);

        $role = Role::create($request->all());

        return redirect()->route('admin.role.index')->with('success', 'Kategori Jadwal created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $kategoriJadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Role $kategoriJadwal)
    {
        return view('admin.role.show', compact('kategoriJadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $kategoriJadwal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategoriJadwal = Role::findOrFail($id);
        return view('admin.role.edit', compact('kategoriJadwal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $kategoriJadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_role' => 'required|unique:roles|max:255',
        ]);

        $kategoriJadwal = Role::findOrFail($id);
        $kategoriJadwal->update($request->all());

        return redirect()->route('admin.role.index')->with('success', 'Kategori Jadwal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $kategoriJadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoriJadwal = Role::findOrFail($id);
        $kategoriJadwal->delete();

        return redirect()->route('admin.role.index')->with('success', 'Kategori Jadwal deleted successfully');
    }
}

