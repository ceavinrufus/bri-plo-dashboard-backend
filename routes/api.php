<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProjectController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/user', [UserController::class, 'index']);

// Pengadaan
Route::get('/pengadaan/{pengadaan:departemen}', [PengadaanController::class, 'index']);
Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
Route::put('/pengadaan/update/{pengadaan}', [PengadaanController::class, 'update'])->name('pengadaan.update');
Route::delete('/pengadaan/delete/{pengadaan}', [PengadaanController::class, 'destroy'])->name('pengadaan.destroy');

// Project
Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/project/store', [ProjectController::class, 'store'])->name('projects.store');
Route::put('/project/update/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/project/delete/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
