<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanContoller;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:karyawan'])->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);
    Route::post('/presensi/prosesAbsen', [PresensiController::class, 'prosesAbsen']);
    Route::get('/presensi/absen', [PresensiController::class, 'absen']);

    Route::get('/presensi/edit', [PresensiController::class, 'profilEdit']);
    Route::post('/presensi/{nik}/edit', [PresensiController::class, 'profilUpdate']);
    Route::get('/presensi/verif', [PresensiController::class, 'verifWajah']);
    Route::post('/presensi/prosesVerif', [PresensiController::class, 'prosesVerif']);

    Route::get('/presensi/riwayat', [PresensiController::class, 'riwayat']);
    Route::post('/getRiwayat', [PresensiController::class, 'getRiwayat']);

    Route::middleware(['admin'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/', [AdminController::class, 'index']);
            Route::get('/karyawan', [KaryawanContoller::class, 'index']);
            Route::resource('/karyawan', KaryawanContoller::class);
            Route::post('/karyawan/store', [KaryawanContoller::class, 'store']);
            Route::post('/karyawan', [KaryawanContoller::class, 'update'])->name('update');
        });
    });





    // Route::get('/profil', [ProfilController::class, 'create']);
    // Route::resource('/profil', ProfilController::class);
});
