<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\HariLiburController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProjectController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/user', [UserController::class, 'index']);

// Pengadaan
Route::get('/pengadaan/departemen/{pengadaan:departemen}', [PengadaanController::class, 'index']);
Route::get('/pengadaan/nomor_spk', [PengadaanController::class, 'getByNomorSpk']);
Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
Route::put('/pengadaan/update/{pengadaan}', [PengadaanController::class, 'update'])->name('pengadaan.update');
Route::delete('/pengadaan/delete/{pengadaan}', [PengadaanController::class, 'destroy'])->name('pengadaan.destroy');
Route::post('pengadaan/import', [PengadaanController::class, 'import']);

// Dokumen
Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
Route::post('/dokumen/store', [DokumenController::class, 'store'])->name('dokumen.store');
Route::put('/dokumen/update/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.update');
Route::delete('/dokumen/delete/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

// Project
Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/project/store', [ProjectController::class, 'store'])->name('projects.store');
Route::put('/project/update/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/project/delete/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Department
Route::get('/department', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/department/store', [DepartmentController::class, 'store'])->name('departments.store');
Route::put('/department/update/{department}', [DepartmentController::class, 'update'])->name('departments.update');
Route::delete('/department/delete/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

// Hari Libur
Route::get('/hari-libur', [HariLiburController::class, 'index'])->name('hari-libur.index');
Route::post('/hari-libur/store', [HariLiburController::class, 'store'])->name('hari-libur.store');
Route::put('/hari-libur/update/{hariLibur}', [HariLiburController::class, 'update'])->name('hari-libur.update');
Route::delete('/hari-libur/delete/{hariLibur}', [HariLiburController::class, 'destroy'])->name('hari-libur.destroy');
