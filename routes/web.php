<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenagaMedisController;

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
    Route::get('/admin/user/tambah', [UserController::class, 'create'])->name('admin.user.create');
    Route::put('admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('admin/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::delete('admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/tenagamedis/filter/{jenis?}', [TenagaMedisController::class, 'index'])->name('admin.tenagamedis.index');

    Route::get('/admin/tenagamedis/tambah', [TenagaMedisController::class, 'create'])->name('admin.tenagamedis.create');
    Route::put('admin/tenagamedis/{id}', [TenagaMedisController::class, 'update'])->name('admin.tenagamedis.update');
    Route::get('/admin/tenagamedis/{id}/edit', [TenagaMedisController::class, 'edit'])->name('admin.tenagamedis.edit');
    Route::post('admin/tenagamedis', [TenagaMedisController::class, 'store'])->name('admin.tenagamedis.store');
    Route::delete('admin/tenagamedis/{id}', [TenagaMedisController::class, 'destroy'])->name('admin.tenagamedis.destroy');
});

require __DIR__.'/auth.php';
