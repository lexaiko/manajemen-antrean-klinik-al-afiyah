<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berita;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah data
        $totalUser = User::count();
        $totalBerita = Berita::count();

        // Kirim ke view
        return view('dashboard', compact('totalUser', 'totalBerita'));
    }
}
