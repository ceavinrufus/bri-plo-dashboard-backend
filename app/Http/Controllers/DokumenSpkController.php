<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenSpk;
use Illuminate\Support\Facades\Log;

class DokumenSpkController extends Controller
{
    public function index()
    {
        $data = DokumenSpk::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_spk_diterima' => 'nullable|date',
            'tim_pemrakarsa' => 'nullable|string|max:255',
            'pic_pengadaan_id' => 'nullable|exists:users,id',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'jangka_waktu' => 'nullable|string|max:255',
            'pelaksana_pekerjaan' => 'nullable|json',
            'pic_pelaksana_pekerjaan' => 'nullable|json',
            'dokumen_pelengkap' => 'nullable|array',
            'info_ke_vendor' => 'nullable|json',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'dokumen_yang_dikembalikan' => 'nullable|array',
            'tkdn_percentage' => 'nullable|numeric',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
            'pic_legal_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string|max:255',
        ]);

        $dokumen = DokumenSpk::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully added!',
            'data' => $dokumen,
        ], 201);
    }

    public function update(Request $request, DokumenSpk $dokumen)
    {
        $validated = $request->validate([
            'tanggal_spk_diterima' => 'nullable|date',
            'tim_pemrakarsa' => 'nullable|string|max:255',
            'pic_pengadaan_id' => 'nullable|exists:users,id',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'jangka_waktu' => 'nullable|string|max:255',
            'pelaksana_pekerjaan' => 'nullable|json',
            'pic_pelaksana_pekerjaan' => 'nullable|json',
            'dokumen_pelengkap' => 'nullable|array',
            'info_ke_vendor' => 'nullable|json',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'dokumen_yang_dikembalikan' => 'nullable|array',
            'tkdn_percentage' => 'nullable|numeric',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
            'pic_legal_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string|max:255',
        ]);

        $dokumen->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully updated!',
            'data' => $dokumen,
        ], 200);
    }

    public function destroy(DokumenSpk $dokumen)
    {
        $dokumen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully deleted!',
        ], 200);
    }
}
