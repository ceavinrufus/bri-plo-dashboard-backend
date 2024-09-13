<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Models\Pengadaan;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});
Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});

Route::get('/data-pengadaan/{pengadaan:departemen}', function (Pengadaan $pengadaan) {
    $data = Pengadaan::where('departemen', $pengadaan->departemen)->get();
    return view('data-pengadaan', ['title' => 'Data Pengadaan' . ' ' . strtoupper($pengadaan->departemen), 'data' => $data]);
});

Route::get('/upload-excel', [ExcelController::class, 'index'])->name('upload.excel');

Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel.submit');
