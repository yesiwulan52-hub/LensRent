<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('home');})->name('home');
Route::get('/kamera', function () {return view('datakamera');})->name('kamera.index');
Route::get('/sewa', function () {return view('formsewa');})->name('sewa.form');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::view('/tentang', 'tentang')->name('tentang');
Route::get('/hitung/{a}/{b}', function ($a, $b) {return $a + $b; });
