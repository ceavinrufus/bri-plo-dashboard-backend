<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});
Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});

Route::get('/upload-excel', [ExcelController::class, 'index'])->name('upload.excel');

Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel.submit');
