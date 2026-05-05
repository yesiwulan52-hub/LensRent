<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\SewaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('home');})->name('home');
Route::get('/kamera', function () {return view('datakamera');})->name('kamera.index');
Route::get('/sewa', function () {return view('formsewa');})->name('sewa.form');
Route::view('/tentang', 'tentang')->name('tentang');

