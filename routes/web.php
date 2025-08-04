<?php

use Illuminate\Support\Facades\Route;
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

// Group route untuk autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Logout sudah ada di sini dan sudah benar
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
// Route::get('/check-session-config', function () {
//     dd(config('session'));
// });

require __DIR__.'/auth.php';

