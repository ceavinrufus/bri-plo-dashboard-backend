<?php

namespace App\Http\Controllers;

use App\Models\DokumenJaminan;
use Illuminate\Http\Request;
use App\Models\DokumenSpk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DokumenSpkController extends Controller
{
    public function index()
    {
        $data = DokumenSpk::all();

        // Modify data to add 'nomor' field and remove unwanted fields
        $data = $data->map(function ($item, $index) {
            // Convert the item to an array
            $itemArray = $item->toArray();

            // Place 'nomor' at the start
            $itemArray['dokumen_jaminans'] = $item->dokumen_jaminans;

            return $itemArray;
        });

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
            'tanggal_info_ke_vendor' => 'nullable|date',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'dokumen_yang_dikembalikan' => 'nullable|array',
            'tkdn_percentage' => 'nullable|numeric',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
            'pic_legal_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string|max:255',
            'dokumen_jaminans' => 'nullable|array',
            'dokumen_jaminans.*.type' => 'required_with:dokumen_jaminans|string|max:255',
            'dokumen_jaminans.*.tanggal_diterima' => 'nullable|date',
            'dokumen_jaminans.*.penerbit' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nomor_jaminan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.dokumen_keabsahan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nilai' => 'nullable|numeric',
            'dokumen_jaminans.*.waktu_mulai' => 'nullable|date',
            'dokumen_jaminans.*.waktu_berakhir' => 'nullable|date',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $dokumen = DokumenSpk::create($validated);

            // Create associated DokumenJaminan if present
            if (isset($validated['dokumen_jaminans'])) {
                foreach ($validated['dokumen_jaminans'] as $dokumenJaminanData) {
                    $dokumen->dokumen_jaminans()->create($dokumenJaminanData);
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Dokumen SPK data successfully added!',
                'data' => $dokumen->load(['dokumenJaminans']),
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();

            // Return a JSON response indicating failure
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add dokumen SPK data.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
            'tanggal_info_ke_vendor' => 'nullable|date',
            'tanggal_pengambilan' => 'nullable|date',
            'identitas_pengambil' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'nullable|date',
            'dokumen_yang_dikembalikan' => 'nullable|array',
            'tkdn_percentage' => 'nullable|numeric',
            'tanggal_penyerahan_dokumen' => 'nullable|date',
            'penerima_dokumen' => 'nullable|string|max:255',
            'pic_legal_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string|max:255',
            'dokumen_jaminans' => 'nullable|array',
            'dokumen_jaminans.*.type' => 'required_with:dokumen_jaminans|string|max:255',
            'dokumen_jaminans.*.tanggal_diterima' => 'nullable|date',
            'dokumen_jaminans.*.penerbit' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nomor_jaminan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.dokumen_keabsahan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nilai' => 'nullable|numeric',
            'dokumen_jaminans.*.waktu_mulai' => 'nullable|date',
            'dokumen_jaminans.*.waktu_berakhir' => 'nullable|date',
        ]);

        try {
            $dokumen->update($validated);

            // Sync DokumenJaminans if present
            if (isset($validated['dokumen_jaminans'])) {
                foreach ($validated['dokumen_jaminans'] as $dokumenJaminanData) {
                    if (isset($dokumenJaminanData['id'])) {
                        // Update existing DokumenJaminan
                        DokumenJaminan::where('id', $dokumenJaminanData['id'])->update($dokumenJaminanData);
                    } else {
                        // Create a new DokumenJaminan
                        $dokumen->nodinUsers()->create($dokumenJaminanData);
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Dokumen SPK data successfully updated!',
                'data' => $dokumen->load(['dokumenJaminans']),
            ], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();

            // Return a JSON response indicating failure
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Dokumen SPK data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(DokumenSpk $dokumen)
    {
        $dokumen->dokumen_jaminans()->delete();

        $dokumen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully deleted!',
        ], 200);
    }
}
