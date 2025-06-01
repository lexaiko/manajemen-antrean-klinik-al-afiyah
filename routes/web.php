<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\TenagaMedisController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JadwalPegawaiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/staff', [UserController::class, 'staff'])->name('admin.user.staff');
    Route::get('/admin/user/tambah', [UserController::class, 'create'])->name('admin.user.create');
    Route::put('admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('admin/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::delete('admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/role', [RoleController::class, 'index'])->name('admin.role.index');
    Route::get('/admin/role/tambah', [RoleController::class, 'create'])->name('admin.role.create');
    Route::put('admin/role/{id}', [RoleController::class, 'update'])->name('admin.role.update');
    Route::get('/admin/role/{id}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
    Route::post('admin/role', [RoleController::class, 'store'])->name('admin.role.store');
    Route::delete('admin/role/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');

    Route::get('/admin/jadwal', [JadwalPegawaiController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/admin/jadwal/tambah', [JadwalPegawaiController::class, 'create'])->name('admin.jadwal.create');
    Route::put('admin/jadwal/{id}', [JadwalPegawaiController::class, 'update'])->name('admin.jadwal.update');
    Route::get('/admin/jadwal/{id}/edit', [JadwalPegawaiController::class, 'edit'])->name('admin.jadwal.edit');
    Route::post('admin/jadwal', [JadwalPegawaiController::class, 'store'])->name('admin.jadwal.store');
    Route::delete('admin/jadwal/{id}', [JadwalPegawaiController::class, 'destroy'])->name('admin.jadwal.destroy');

    Route::get('/admin/jadwal/kalender', [KalenderController::class, 'index'])->name('admin.kalender');
});

require __DIR__.'/auth.php';
