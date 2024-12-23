<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPerjanjian;
use Illuminate\Support\Facades\Log;

class DokumenPerjanjianController extends Controller
{
    public function index()
    {
        $data = DokumenPerjanjian::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_permohonan_diterima' => 'nullable|date',
            'tim_pemrakarsa' => 'nullable|string|max:255',
            'pic_pengadaan_id' => 'nullable|exists:users,id',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'jangka_waktu' => 'nullable|string|max:255',
            'pelaksana_pekerjaan' => 'nullable|json',
            'pic_pelaksana_pekerjaan' => 'nullable|string',
            'nomor_kontrak' => 'required|string|max:255',
            'tanggal_kontrak' => 'required|date',
            'pic_legal_id' => 'nullable|exists:users,id',
        ]);

        $dokumen = DokumenPerjanjian::create($validated);
        Log::info($dokumen);
        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully added!',
            'data' => $dokumen,
        ], 201);
    }

    public function update(Request $request, DokumenPerjanjian $dokumen)
    {
        $validated = $request->validate([
            'tanggal_permohonan_diterima' => 'nullable|date',
            'tim_pemrakarsa' => 'nullable|string|max:255',
            'pic_pengadaan_id' => 'nullable|exists:users,id',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'jangka_waktu' => 'nullable|string|max:255',
            'pelaksana_pekerjaan' => 'nullable|json',
            'pic_pelaksana_pekerjaan' => 'nullable|string',
            'nomor_kontrak' => 'required|string|max:255',
            'tanggal_kontrak' => 'required|date',
            'pic_legal_id' => 'nullable|exists:users,id',
        ]);

        $dokumen->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully updated!',
            'data' => $dokumen,
        ], 200);
    }

    public function destroy(DokumenPerjanjian $dokumen)
    {
        $dokumen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully deleted!',
        ], 200);
    }
}
