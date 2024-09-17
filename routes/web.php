<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Models\Pengadaan;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});
Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});

Route::get('/data-pengadaan/{pengadaan:departemen}', function (Pengadaan $pengadaan) {
    // Ambil data dari model Pengadaan sesuai departemen
    $data = Pengadaan::where('departemen', $pengadaan->departemen)->get();

    // Modifikasi data untuk menambahkan kolom nomor di urutan pertama dan menghapus id
    $data = $data->map(function ($item, $index) {
        // Ubah item ke array
        $itemArray = $item->toArray();
        unset($itemArray['id']);  // Hapus kolom 'id'
        unset($itemArray['departemen']);  // Hapus kolom 'id'
        unset($itemArray['created_at']);  // Hapus kolom 'id'
        unset($itemArray['updated_at']);  // Hapus kolom 'id'

        // Tempatkan kolom 'nomor' di urutan pertama
        $itemArray = array_merge(['nomor' => $index + 1], $itemArray);

        return $itemArray;
    });

    // Kembalikan ke view dengan data yang sudah dimodifikasi
    return view('data-pengadaan', [
        'title' => 'Data Pengadaan ' . strtoupper($pengadaan->departemen),
        'data' => $data
    ]);
});

Route::get('/upload-excel', [ExcelController::class, 'index'])->name('upload.excel');

Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel.submit');

Route::post('/pengadaan/store', function (Request $request) {
    // Validasi data yang dikirim dari form
    $validated = $request->validate([
        'departemen' => 'required|in:bcp,igp,psr',
        'nama_pengadaan' => 'required|string|max:255',
        'tanggal_nodin' => 'nullable|date',
        'tanggal_spk' => 'nullable|date',
        'hari_pengerjaan' => 'nullable|integer',
        'metode' => 'nullable|in:Pemilihan Langsung,Penunjukkan Langsung,Lelang',
        'progres' => 'nullable|string|max:255',
        'hari_proses' => 'nullable|integer',
        'progres_pengadaan' => 'nullable|string|max:255',
    ]);

    // Simpan data ke tabel pengadaans
    Pengadaan::create($validated);

    // Redirect kembali ke halaman data pengadaan
    return redirect()->back()->with('success', 'Data pengadaan berhasil ditambahkan!');
})->name('pengadaan.store');
