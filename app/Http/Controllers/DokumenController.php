<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    public function index()
    {
        $data = Dokumen::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'nama_vendor' => 'required|string|max:255',
            'pic_id' => 'required|exists:users,id',
            'sla_spk_sejak_terbit' => 'nullable|integer',
            'sla_spk_sejak_diambil' => 'nullable|integer',
            'tanggal' => 'required|date',
            'jangka_waktu' => 'nullable|string|max:255',
            'tim' => 'required|string|max:3',
            'nilai_spk' => 'required|numeric',
            'identitas_vendor' => 'nullable|string|max:255',
            'info_vendor' => 'nullable|string|max:255',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'catatan' => 'nullable|string|max:255',
            'form_tkdn' => 'nullable|string|max:255',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
        ]);

        $dokumen = Dokumen::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen data successfully added!',
            'data' => $dokumen,
        ], 201);
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'nama_vendor' => 'required|string|max:255',
            'pic_id' => 'required|exists:users,id',
            'sla_spk_sejak_terbit' => 'nullable|integer',
            'sla_spk_sejak_diambil' => 'nullable|integer',
            'tanggal' => 'required|date',
            'jangka_waktu' => 'nullable|string|max:255',
            'tim' => 'required|string|max:3',
            'nilai_spk' => 'required|numeric',
            'identitas_vendor' => 'nullable|string|max:255',
            'info_vendor' => 'nullable|string|max:255',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'catatan' => 'nullable|string|max:255',
            'form_tkdn' => 'nullable|string|max:255',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
        ]);

        $dokumen->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen data successfully updated!',
            'data' => $dokumen,
        ], 200);
    }

    public function destroy(Dokumen $dokumen)
    {
        $dokumen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen data successfully deleted!',
        ], 200);
    }
}
