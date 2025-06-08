<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KehadiranController;
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
    
    Route::post('/kehadiran/masuk', [KehadiranController::class, 'absenMasuk'])->name('kehadiran.masuk');
    Route::post('/kehadiran/pulang', [KehadiranController::class, 'absenPulang'])->name('kehadiran.pulang');
    Route::get('/kehadiran/izin', [KehadiranController::class, 'izin'])->name('kehadiran.izin');
    
    
    Route::post('/kehadiran/izin', [KehadiranController::class, 'submitLeave'])->name('kehadiran.submit-leave');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
