<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdigiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Data Sales
Route::get('/data-sales', [SalesController::class, 'index'])->name('sales.index');

// Data Pelanggan
Route::get('/data-pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

// Data Prodigi
Route::get('/data-prodigi', [ProdigiController::class, 'index'])->name('prodigi.index');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Data Sales
Route::get('/data-sales', [SalesController::class, 'index'])->middleware('auth')->name('sales.index');

// Data Pelanggan
Route::get('/data-pelanggan', [PelangganController::class, 'index'])->middleware('auth')->name('pelanggan.index');

// Data Prodigi
Route::get('/data-prodigi', [ProdigiController::class, 'index'])->middleware('auth')->name('prodigi.index');

// Group route yang butuh login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Route bawaan dari Breeze/Jetstream/etc
require __DIR__.'/auth.php';
