<?php

namespace App\Http\Controllers;

use App\Models\DokumenJaminan;
use Illuminate\Http\Request;
use App\Models\DokumenSpk;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
            $itemArray['dokumen_jaminans'] = $item->dokumenJaminans;

            return $itemArray;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Get headers from first row and convert to lowercase
            $headers = array_map('strtolower', $rows[0]);

            // Remove first row (headers)
            array_shift($rows);

            $successCount = 0;
            $errorRows = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                try {
                    // Convert row to associative array
                    $data = array_combine($headers, $row);

                    // Prepare DokumenSpk data
                    $dokumenSpkData = [
                        'tanggal_spk_diterima' => $data['tanggal_spk_diterima'] ?? null,
                        'tim_pemrakarsa' => $data['tim_pemrakarsa'] ?? null,
                        'pic_pengadaan_id' => $data['pic_pengadaan_id'] ?? null,
                        'nomor_spk' => $data['nomor_spk'] ?? null,
                        'tanggal_spk' => $data['tanggal_spk'] ?? null,
                        'jenis_pekerjaan' => $data['jenis_pekerjaan'] ?? null,
                        'spk' => json_encode([
                            'currency' => $data['currency_spk'] ?? null,
                            'amount' => isset($data['nilai_spk']) ? (float)$data['nilai_spk'] : null,
                            'rate' => isset($data['rate_spk']) ? (float)$data['rate_spk'] : null,
                        ]),
                        'jangka_waktu' => $data['jangka_waktu'] ?? null,
                        'pelaksana_pekerjaan' => json_encode([
                            'name' => $data['pelaksana_pekerjaan'] ?? null,
                            'address' => $data['alamat_pelaksana_pekerjaan'] ?? null,
                            'phone_number' => $data['no_telp_pelaksana_pekerjaan'] ?? null,
                        ]),
                        'pic_pelaksana_pekerjaan' => $data['pic_pelaksana_pekerjaan'] ?? null,
                        'dokumen_pelengkap' => $data['dokumen_pelengkap'] ?? null,
                        'tanggal_info_ke_vendor' => $data['tanggal_info_ke_vendor'] ?? null,
                        'tanggal_pengambilan' => $data['tanggal_pengambilan'] ?? null,
                        'identitas_pengambil' => $data['identitas_pengambil'] ?? null,
                        'tanggal_pengembalian' => $data['tanggal_pengembalian'] ?? null,
                        'dokumen_yang_dikembalikan' => $data['dokumen_yang_dikembalikan'] ?? null,
                        'tkdn_percentage' => $data['tkdn_percentage'] ?? null,
                        'tanggal_penyerahan_dokumen' => $data['tanggal_penyerahan_dokumen'] ?? null,
                        'penerima_dokumen' => $data['penerima_dokumen'] ?? null,
                        'pic_legal_id' => $data['pic_legal_id'] ?? null,
                        'catatan' => $data['catatan'] ?? null,
                    ];

                    // Create a new DokumenSpk record
                    $dokumenSpk = DokumenSpk::create($dokumenSpkData);

                    // Prepare DokumenJaminan data
                    $jaminanTypes = ['uang_muka', 'pembayaran', 'pelaksanaan', 'pemeliharaan'];
                    $typeMapping = [
                        'uang_muka' => 'JUM',
                        'pembayaran' => 'JBayar',
                        'pelaksanaan' => 'Jampel',
                        'pemeliharaan' => 'JPelihara',
                    ];
                    foreach ($jaminanTypes as $type) {
                        if (isset($data["tanggal_diterima_jaminan_$type"])) {
                            $dokumenJaminanData = [
                                'type' => $typeMapping[$type],
                                'tanggal_diterima' => $data["tanggal_diterima_jaminan_$type"] ?? null,
                                'penerbit' => $data["penerbit_jaminan_$type"] ?? null,
                                'nomor_jaminan' => $data["nomor_jaminan_jaminan_$type"] ?? null,
                                'dokumen_keabsahan' => $data["dokumen_keabsahan_jaminan_$type"] ?? null,
                                'nilai' => json_encode([
                                    'currency' => $data["currency_jaminan_$type"] ?? null,
                                    'amount' => $data["nilai_jaminan_$type"] ?? null,
                                    'rate' => $data["rate_jaminan_$type"] ?? null,
                                ]),
                                'waktu_mulai' => $data["waktu_mulai_jaminan_$type"] ?? null,
                                'waktu_berakhir' => $data["waktu_berakhir_jaminan_$type"] ?? null,
                            ];
                            $dokumenSpk->dokumenJaminans()->create($dokumenJaminanData);
                        }
                    }

                    $successCount++;
                } catch (\Exception $e) {
                    $errorRows[] = [
                        'row' => $index + 2, // Add 2 because: 1 for header, 1 for zero-based index
                        'error' => $e->getMessage()
                    ];
                }
            }

            if ($successCount > 0) {
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => "$successCount records imported successfully",
                    'errors' => count($errorRows) > 0 ? $errorRows : null,
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'No records were imported',
                    'errors' => $errorRows
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process Excel file: ' . $e->getMessage()
            ], 500);
        }
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
            'pic_pelaksana_pekerjaan' => 'nullable|string',
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
            'dokumen_jaminans.*.nilai' => 'nullable|json',
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
                    $dokumen->dokumenJaminans()->create($dokumenJaminanData);
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
            'pic_pelaksana_pekerjaan' => 'nullable|string',
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
            'dokumen_jaminans.*.id' => 'nullable|exists:dokumen_jaminans,id',
            'dokumen_jaminans.*.type' => 'required_with:dokumen_jaminans|string|max:255',
            'dokumen_jaminans.*.tanggal_diterima' => 'nullable|date',
            'dokumen_jaminans.*.penerbit' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nomor_jaminan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.dokumen_keabsahan' => 'nullable|string|max:255',
            'dokumen_jaminans.*.nilai' => 'nullable|json',
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
                        $dokumen->dokumenJaminans()->create($dokumenJaminanData);
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
        $dokumen->dokumenJaminans()->delete();

        $dokumen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen SPK data successfully deleted!',
        ], 200);
    }
}
