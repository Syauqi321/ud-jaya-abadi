<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
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
Route::resource('pelanggan', PelangganController::class);

