<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HargaJualController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProsesProduksiController;
use App\Http\Controllers\HasilProduksiController;
use App\Http\Controllers\LaporanProduksiController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('dashboard.index');
})->name('index');

/*
|---------------------------------------------------------------------------
| Data Master
|---------------------------------------------------------------------------
*/
Route::resource('bahan', BahanController::class);
Route::resource('produk', ProdukController::class);
Route::resource('harga-jual', HargaJualController::class);
Route::patch('/harga-jual/{id}/toggle-status', [HargaJualController::class, 'toggleStatus'])->name('harga_jual.toggleStatus');
Route::resource('pelanggan', PelangganController::class);

/*
|---------------------------------------------------------------------------
| Transaksi
|---------------------------------------------------------------------------
*/
Route::resource('pembelian', PembelianController::class);
Route::resource('penjualan', PenjualanController::class);

/*
|---------------------------------------------------------------------------
| Produksi
|---------------------------------------------------------------------------
*/
Route::resource('proses-produksi', ProsesProduksiController::class);
Route::resource('hasil-produksi', HasilProduksiController::class);

/*
|---------------------------------------------------------------------------
| Laporan
|---------------------------------------------------------------------------
*/
Route::get('/laporan-produksi', [LaporanProduksiController::class, 'index'])->name('laporan.produksi.index');
Route::get('/laporan-produksi/pdf', [LaporanProduksiController::class, 'downloadPdf'])->name('laporan.produksi.pdf');
