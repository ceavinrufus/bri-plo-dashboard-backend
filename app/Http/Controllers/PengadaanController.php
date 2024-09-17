<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    public function index(Pengadaan $pengadaan)
    {
        // Ambil data dari model Pengadaan sesuai departemen
        $data = Pengadaan::where('departemen', $pengadaan->departemen)->get();

        // Modifikasi data untuk menambahkan kolom nomor di urutan pertama dan menghapus kolom yang tidak diinginkan
        $data = $data->map(function ($item, $index) {
            // Ubah item ke array
            $itemArray = $item->toArray();
            // Hapus kolom yang tidak diinginkan
            unset($itemArray['id']);
            unset($itemArray['departemen']);
            unset($itemArray['created_at']);
            unset($itemArray['updated_at']);

            // Tempatkan kolom 'nomor' di urutan pertama
            $itemArray = array_merge(['nomor' => $index + 1], $itemArray);

            return $itemArray;
        });

        // Kembalikan ke view dengan data yang sudah dimodifikasi
        return view('data-pengadaan', [
            'title' => 'Data Pengadaan ' . strtoupper($pengadaan->departemen),
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
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
    }
}
