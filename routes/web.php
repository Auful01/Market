<?php

use App\Http\Controllers\InfoController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PasarController;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function () {
    # code...
    Route::get('konfig', function () {
        return view('admin.konfigurasi');
    });
    Route::resource('pasar', PasarController::class);
    Route::resource('informasi', InformasiController::class);
    Route::resource('info', InfoController::class);
    Route::get('load-info', [InfoController::class, 'loadInfo'])->name('load-info');
    Route::delete('delete-info', [InfoController::class, 'deleteInfo'])->name('delete-info');
    Route::get('load-pasar', [PasarController::class, 'loadPasar'])->name('load-pasar');
    Route::put('update-pasar', [PasarController::class, 'updatePasar'])->name('update-pasar');
    // Route::delete('delete-pasar', [PasarController::class, 'deletePasar'])->name('delete-pasar');
    Route::get('load-komoditas', [KomoditasController::class, 'loadKomoditas'])->name('load-komoditas');
    Route::put('update-komoditas', [KomoditasController::class, 'updateKomoditas'])->name('update-komoditas');
    Route::delete('delete-komoditas', [KomoditasController::class, 'deleteKomoditas'])->name('delete-komoditas');
    Route::put('update-kategori', [KategoriController::class, 'updateKategori'])->name('update-kategori');
    Route::delete('delete-kategori', [KategoriController::class, 'deleteKategori'])->name('delete-kategori');
    Route::get('load-kategori', [KategoriController::class, 'loadKategori'])->name('load-kategori');
    Route::get('kategori-detail', [KategoriController::class, 'findKategori'])->name('kategori-detail');
    Route::resource('komoditas', KomoditasController::class);
    Route::resource('kategori', KategoriController::class);
});
Route::get('/', function () {
    return view('dashboard');
});
Route::get('load-pasar', [PasarController::class, 'loadPasar'])->name('load-pasar');
Route::get('load-laporan', [LaporanController::class, 'loadLaporan'])->name('load-laporan');
Route::get('load-dashboard', [LaporanController::class, 'loadDashboard'])->name('load-dashboard');
Route::get('/laporan', function () {
    return view('guest.laporan');
});
Route::get('export/', [LaporanController::class, 'export']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
