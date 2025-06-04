<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\KehadiranController::class, 'dashboard'])->name('dashboard');
    
    Route::post('/kehadiran/masuk', [\App\Http\Controllers\KehadiranController::class, 'absenMasuk'])->name('kehadiran.masuk');
    Route::post('/kehadiran/pulang', [\App\Http\Controllers\KehadiranController::class, 'absenPulang'])->name('kehadiran.pulang');
    Route::get('/kehadiran/izin', [\App\Http\Controllers\KehadiranController::class, 'izin'])->name('kehadiran.izin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
