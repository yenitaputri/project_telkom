<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PelangganController; // Import Controller baru
use App\Http\Controllers\ProdigiController;    // Import Controller baru

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

// Route untuk Beranda (Root URL)
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Route untuk Data Sales
Route::get('/data-sales', [SalesController::class, 'index'])->name('sales.index');

// Route untuk Data Pelanggan
Route::get('/data-pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

// Route untuk Data Prodigi
Route::get('/data-prodigi', [ProdigiController::class, 'index'])->name('prodigi.index');