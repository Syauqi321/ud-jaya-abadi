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
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Carbon\Carbon;

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
    $year = now()->year;

    // Ambil data pembelian & penjualan grup per bulan
    $pembelianPerBulan = Pembelian::selectRaw('MONTH(created_at) as bulan, SUM(total) as total')
        ->whereYear('created_at', $year)
        ->groupByRaw('MONTH(created_at)')
        ->pluck('total', 'bulan');

    $penjualanPerBulan = Penjualan::with('detailPenjualan')
        ->whereYear('created_at', $year)
        ->get()
        ->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->month;
        })
        ->map(function ($items) {
            return $items->sum('total'); // memakai accessor getTotalAttribute
        });

    // Format data untuk Chart.js
    $bulan = collect(range(1, 12))->map(function ($i) {
        return Carbon::create()->month($i)->translatedFormat('F');
    });

    $dataPembelian = collect(range(1, 12))->map(fn ($i) => $pembelianPerBulan[$i] ?? 0);
    $dataPenjualan = collect(range(1, 12))->map(fn ($i) => $penjualanPerBulan[$i] ?? 0);

    return view('dashboard.index', compact('bulan', 'dataPembelian', 'dataPenjualan'));
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
Route::get('/laporan/keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan.index');
Route::get('/laporan/keuangan/pdf', [LaporanKeuanganController::class, 'downloadPdf'])->name('laporan.keuangan.pdf');

/*
|---------------------------------------------------------------------------
| Login
|---------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
