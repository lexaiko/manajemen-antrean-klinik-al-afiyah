<?php

namespace App\Http\Controllers;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $users = Antrian::paginate(5);
        return view('admin.user.index', compact('users'));
    }
}
