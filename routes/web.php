<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\TenagaMedisController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JadwalPegawaiController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoliController;

Route::get('/antrean/list', [AntrianController::class, 'antreanIndex'])->name('antrean.index');
Route::get('/', [BeritaController::class, 'beranda'])->name('beranda');
Route::get('/berita/{slug}', [BeritaController::class, 'showBeranda'])->name('berita.detail');
Route::get('/berita', [BeritaController::class, 'indexBeranda'])->name('berita.index');
Route::get('/jadwal', [JadwalPegawaiController::class, 'jadwalBeranda'])->name('jadwal.index');
Route::get('/antrean/detail/{id}', [AntrianController::class, 'berandaDetail'])->name('antrean.detail');
Route::get('/antrean/{id}/pdf', [AntrianController::class, 'downloadPdf'])->name('antrean.downloadPdf');

Route::get('/antrean/daftar', [AntrianController::class, 'registrasi'])->name('antrean.registrasi');
Route::post('/antrean/daftar', [AntrianController::class, 'registrasiStore'])->name('antrean.storeRegistrasi');

Route::group(['middleware' => ['role:admin klinik|dokter umum|dokter gigi|bidan|perawat']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/admin/antrean', [AntrianController::class, 'index'])->name('admin.antrian.index');
Route::get('/admin/antrean/riwayat', [AntrianController::class, 'riwayat'])->name('admin.antrian.riwayat');
Route::get('/admin/antrean/detail', [AntrianController::class, 'detail'])->name('admin.antrian.detail');
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
Route::get('/admin/jadwal', [JadwalPegawaiController::class, 'index'])->name('admin.jadwal.index');
Route::get('/admin/poli', [PoliController::class, 'index'])->name('admin.poli');
    // + semua route create/update/delete lainnya
});

Route::group(['middleware' => ['role:admin klinik']], function () {

    Route::get('/admin/antrean/detail/{id}', [AntrianController::class, 'showDetail'])->name('admin.antrean.show');

Route::prefix('admin/antrean/control')->name('admin.antrean.control.')->group(function () {
    Route::get('/', [AntrianController::class, 'controlIndex'])->name('index');
    Route::post('/next/{poli}', [AntrianController::class, 'next'])->name('next');
});


    Route::get('/admin/antrean/monitoring/data', [AntrianController::class, 'adminMonitoringData'])->name('admin.antrean.monitoring.data');

    Route::get('/admin/monitoring', [AntrianController::class, 'adminMonitoring'])->name('admin.monitoring');




    Route::get('/admin/antrean/create', [AntrianController::class, 'create'])->name('admin.antrian.create');
    Route::get('/admin/antrean/{id}/edit', [AntrianController::class, 'edit'])->name('admin.antrian.edit');
    Route::post('/admin/antrean', [AntrianController::class, 'store'])->name('admin.antrian.store');

    Route::put('/admin/antrean/{id}/edit', [AntrianController::class, 'update'])->name('admin.antrian.update');
    Route::delete('/admin/antrean/{id}', [AntrianController::class, 'destroy'])->name('admin.antrian.destroy');


    Route::get('/admin/poli/create', [PoliController::class, 'create'])->name('admin.poli.create');
    Route::post('/admin/poli', [PoliController::class, 'store'])->name('admin.poli.store');
    Route::get('/admin/poli/{id}/edit', [PoliController::class, 'edit'])->name('admin.poli.edit');
    Route::put('/admin/poli/{id}', [PoliController::class, 'update'])->name('admin.poli.update');
    Route::delete('/admin/poli/{id}', [PoliController::class, 'destroy'])->name('admin.poli.destroy');





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


    Route::get('/admin/jadwal/tambah', [JadwalPegawaiController::class, 'create'])->name('admin.jadwal.create');
    Route::put('admin/jadwal/{id}', [JadwalPegawaiController::class, 'update'])->name('admin.jadwal.update');
    Route::get('/admin/jadwal/{id}/edit', [JadwalPegawaiController::class, 'edit'])->name('admin.jadwal.edit');
    Route::post('admin/jadwal', [JadwalPegawaiController::class, 'store'])->name('admin.jadwal.store');
    Route::delete('admin/jadwal/{id}', [JadwalPegawaiController::class, 'destroy'])->name('admin.jadwal.destroy');
        //berita
    Route::get('admin/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::get('admin/berita/create', [BeritaController::class, 'create'])->name('admin.berita.create');
    Route::post('admin/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('admin/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('admin/berita/{berita}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('admin/berita/{berita}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
    Route::delete('admin/deleteall', [BeritaController::class, 'deleteAll'])->name('admin.berita.deleteAll');
    Route::get('admin/berita/search', [BeritaController::class, 'search'])->name('admin.berita.search');
    Route::post('summernote/picture/upload/{type}', [BeritaController::class, 'uploadImageSummernote']);
    Route::post('summernote/picture/delete/{type}', [BeritaController::class, 'uploadImageSummernote']);
});

require __DIR__ . '/auth.php';
