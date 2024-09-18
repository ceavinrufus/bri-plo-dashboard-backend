<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PengadaanController;

Route::get('/', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});

Route::get('/data-pengadaan/{pengadaan:departemen}', [PengadaanController::class, 'index']);

Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
