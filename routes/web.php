<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\ClusteringController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Apps\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Apps\RekomendasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Apps\PreferensiController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Controller::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/store', [AuthController::class, 'store'])->name('store.register');


// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Shift routes
    Route::resource('shift', App\Http\Controllers\Admin\ShiftController::class);
    Route::post('/shift/penjadwalan-otomatis', [App\Http\Controllers\Admin\ShiftController::class, 'penjadwalanOtomatis'])->name('shift.penjadwalanOtomatis');

    // Cuti routes
    Route::resource('cuti', App\Http\Controllers\Admin\CutiController::class);

    // Gaji routes
    Route::resource('gaji', App\Http\Controllers\Admin\GajiController::class);
    Route::post('/gaji/gaji-otomatis', [App\Http\Controllers\Admin\GajiController::class, 'prosesGajiOtomatis'])->name('gaji.prosesOtomatis');

    // Kinerja routes
    // Route::resource('kinerja', App\Http\Controllers\Admin\KinerjaController::class);

    // Rule routes
    Route::resource('rule-gaji', App\Http\Controllers\Admin\RuleGajiController::class); 
    Route::resource('rule-shift', App\Http\Controllers\Admin\RuleShiftController::class);

    // Karyawan routes
    Route::resource('karyawan', App\Http\Controllers\Admin\KaryawanController::class);

    // Presensi routes
    // Route::resource('presensi', App\Http\Controllers\Admin\PresensiController::class);
    // Route::get('presensi/rekap', [App\Http\Controllers\Admin\PresensiController::class, 'rekap'])->name('presensi.rekap');
});

// User routes
Route::prefix('user')->middleware(['auth', 'role:karyawan'])->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/shift', [App\Http\Controllers\User\ShiftController::class, 'index'])->name('shift');
    Route::post('/shift/{id}/ambil', [App\Http\Controllers\User\ShiftController::class, 'ambilShift'])->name('shift.ambil');
    Route::post('/shift/{id}/selesai', [App\Http\Controllers\User\ShiftController::class, 'selesaiShift'])->name('shift.selesai');
    Route::get('/gaji', [App\Http\Controllers\User\GajiController::class, 'index'])->name('gaji');
    Route::get('/gaji/{id}/detail', [App\Http\Controllers\User\GajiController::class, 'detail'])->name('gaji.detail');
    Route::get('/cuti', [App\Http\Controllers\User\CutiController::class, 'index'])->name('cuti');
    Route::post('/cuti', [App\Http\Controllers\User\CutiController::class, 'store'])->name('cuti.store');
});

