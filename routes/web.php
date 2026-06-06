<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk kamera (index publik atau hanya untuk user login? lihat kebutuhan)
// Sesuai RTM, perlu proteksi halaman yang memerlukan login. Kita buat index untuk user login saja.
Route::middleware(['auth'])->group(function () {
    Route::get('/kamera', [KameraController::class, 'index'])->name('kamera.index');
    Route::get('/kamera/{kamera}', [KameraController::class, 'show'])->name('kamera.show');
});

// CRUD kamera hanya admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kamera', [KameraController::class, 'index'])->name('kamera.index');
    Route::get('/kamera/create', [KameraController::class, 'create'])->name('kamera.create');
    Route::post('/kamera', [KameraController::class, 'store'])->name('kamera.store');
    Route::get('/kamera/{kamera}/edit', [KameraController::class, 'edit'])->name('kamera.edit');
    Route::put('/kamera/{kamera}', [KameraController::class, 'update'])->name('kamera.update');
    Route::delete('/kamera/{kamera}', [KameraController::class, 'destroy'])->name('kamera.destroy');
    Route::patch('/kamera/{kamera}/toggle-status', [KameraController::class, 'toggleStatus'])->name('kamera.toggle');
});

// Route untuk sewa (customer)
Route::middleware(['auth'])->group(function () {
    Route::get('/sewa', [SewaController::class, 'index'])->name('sewa.index');
    Route::get('/sewa/create', [SewaController::class, 'create'])->name('sewa.create');
    Route::post('/sewa', [SewaController::class, 'store'])->name('sewa.store');
    Route::delete('/sewa/{sewa}', [SewaController::class, 'destroy'])->name('sewa.destroy');
});

// Route profil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
