<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data-pengadaan/{pengadaan:departemen}', [PengadaanController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);

Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
