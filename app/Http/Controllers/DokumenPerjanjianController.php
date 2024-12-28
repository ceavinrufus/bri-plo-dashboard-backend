<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPerjanjian;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
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

                    // Prepare DokumenPerjanjian data
                    $dokumenPerjanjianData = [
                        'tanggal_permohonan_diterima' => $data['tanggal_permohonan_diterima'] ?? null,
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
                        'nomor_kontrak' => $data['nomor_kontrak'] ?? null,
                        'tanggal_kontrak' => $data['tanggal_kontrak'] ?? null,
                        'pic_legal_id' => $data['pic_legal_id'] ?? null,
                    ];

                    // Create a new DokumenPerjanjian record
                    DokumenPerjanjian::create($dokumenPerjanjianData);

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
