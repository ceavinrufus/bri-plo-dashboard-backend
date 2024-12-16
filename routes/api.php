<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DokumenPerjanjianController;
use App\Http\Controllers\DokumenSpkController;
use App\Http\Controllers\HariLiburController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RekapPembayaranController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);

// Pengadaan
Route::get('/pengadaan/departemen/{pengadaan:departemen}', [PengadaanController::class, 'index']);
Route::get('/pengadaan/nomor_spk', [PengadaanController::class, 'getByNomorSpk']);
Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');
Route::put('/pengadaan/update/{pengadaan}', [PengadaanController::class, 'update'])->name('pengadaan.update');
Route::delete('/pengadaan/delete/{pengadaan}', [PengadaanController::class, 'destroy'])->name('pengadaan.destroy');
Route::post('pengadaan/import', [PengadaanController::class, 'import']);

// Dokumen SPK
Route::get('/dokumen/spk', [DokumenSpkController::class, 'index'])->name('dokumen.spk.index');
Route::post('/dokumen/spk/store', [DokumenSpkController::class, 'store'])->name('dokumen.spk.store');
Route::put('/dokumen/spk/update/{dokumen}', [DokumenSpkController::class, 'update'])->name('dokumen.spk.update');
Route::delete('/dokumen/spk/delete/{dokumen}', [DokumenSpkController::class, 'destroy'])->name('dokumen.spk.destroy');

// Dokumen Perjanjian
Route::get('/dokumen/perjanjian', [DokumenPerjanjianController::class, 'index'])->name('dokumen.perjanjian.index');
Route::post('/dokumen/perjanjian/store', [DokumenPerjanjianController::class, 'store'])->name('dokumen.perjanjian.store');
Route::put('/dokumen/perjanjian/update/{dokumen}', [DokumenPerjanjianController::class, 'update'])->name('dokumen.perjanjian.update');
Route::delete('/dokumen/perjanjian/delete/{dokumen}', [DokumenPerjanjianController::class, 'destroy'])->name('dokumen.perjanjian.destroy');

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

// Rekap Pembayaran
Route::get('/rekap-pembayaran', [RekapPembayaranController::class, 'index']);
Route::post('/rekap-pembayaran/store', [RekapPembayaranController::class, 'store']);
Route::put('/rekap-pembayaran/update/{rekapPembayaran}', [RekapPembayaranController::class, 'update']);
Route::delete('/rekap-pembayaran/delete/{rekapPembayaran}', [RekapPembayaranController::class, 'destroy']);
Route::post('/rekap-pembayaran/import', [RekapPembayaranController::class, 'import']);
