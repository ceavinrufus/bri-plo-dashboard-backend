<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PengadaanController;
use App\Models\Pengadaan;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('dashboard', ['title' => 'Dashboard', 'tit' => 'dash']);
});

Route::get('/data-pengadaan/{pengadaan:departemen}', [PengadaanController::class, 'index']);

Route::get('/upload-excel', [ExcelController::class, 'index'])->name('upload.excel');

Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel.submit');

Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
