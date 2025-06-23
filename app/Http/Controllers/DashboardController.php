<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah data
        $totalUser = User::count();
        $totalBerita = Berita::count();
        $totalAntrian = Antrian::count();
        $totalAntrianHariIni = Antrian::whereDate('tanggal_kunjungan', now()->toDateString())->count();

        // Kirim ke view
        return view('dashboard', compact('totalUser', 'totalBerita', 'totalAntrian', 'totalAntrianHariIni'));
    }
}
