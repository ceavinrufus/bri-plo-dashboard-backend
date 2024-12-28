<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapPembayaran;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class RekapPembayaranController extends Controller
{
    public function index()
    {
        $data = RekapPembayaran::all();

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

            $headers = array_map('strtolower', $rows[0]);
            array_shift($rows);

            $successCount = 0;
            $errorRows = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                try {
                    $data = array_combine($headers, $row);

                    $rekapPembayaranData = [
                        'pic_pc_id' => $data['pic_pc_id'] ?? null,
                        'tanggal_terima' => $this->parseExcelDate($data['tanggal_terima'] ?? null),
                        'nomor_spk' => $data['nomor_spk'] ?? null,
                        'tanggal_spk' => $this->parseExcelDate($data['tanggal_spk'] ?? null),
                        'nomor_perjanjian' => $data['nomor_perjanjian'] ?? null,
                        'tanggal_perjanjian' => $this->parseExcelDate($data['tanggal_perjanjian'] ?? null),
                        'perihal' => $data['perihal'] ?? null,
                        'spk' => json_encode([
                            'currency' => $data['currency_spk'] ?? null,
                            'amount' => isset($data['nilai_spk']) ? (float)$data['nilai_spk'] : null ?? null,
                            'rate' => isset($data['rate_spk']) ? (float)$data['rate_spk'] : null ?? null,
                        ]),
                        'vendor' => $data['vendor'] ?? null,
                        'tkdn' => $data['tkdn'] ?? null,
                        'nomor_invoice' => $data['nomor_invoice'] ?? null,
                        'invoice' => json_encode([
                            'currency' => $data['currency_invoice'] ?? null,
                            'amount' => isset($data['nominal_invoice']) ? (float)$data['nominal_invoice'] : null ?? null,
                            'rate' => isset($data['rate_invoice']) ? (float)$data['rate_invoice'] : null ?? null,
                        ]),
                        'nomor_rekening' => $data['nomor_rekening'] ?? null,
                        'pic_pay_id' => $data['pic_pay_id'] ?? null,
                        'nota_fiat' => $data['nota_fiat'] ?? null,
                        'tanggal_fiat' => $this->parseExcelDate($data['tanggal_fiat'] ?? null),
                        'sla' => $this->parseExcelDate($data['sla'] ?? null),
                        'hari_pengerjaan' => $data['hari_pengerjaan'] ?? null,
                        'status_pembayaran' => $data['status_pembayaran'] ?? null,
                        'tanggal_pembayaran' => $this->parseExcelDate($data['tanggal_pembayaran'] ?? null),
                        'keterangan' => $data['keterangan'] ?? null,
                    ];

                    RekapPembayaran::create($rekapPembayaranData);
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    $errorRows[] = [
                        'row' => $index + 2,
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

    private function parseExcelDate($value)
    {
        if (empty($value)) return null;

        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }

            return date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pic_pc_id' => 'nullable|exists:users,id',
            'tanggal_terima' => 'nullable|date',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'nomor_perjanjian' => 'nullable|string|max:255',
            'tanggal_perjanjian' => 'nullable|date',
            'perihal' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'vendor' => 'nullable|string|max:255',
            'tkdn' => 'nullable|numeric',
            'nomor_invoice' => 'nullable|string|max:255',
            'invoice' => 'nullable|json',
            'nomor_rekening' => 'nullable|string|max:255',
            'pic_pay_id' => 'nullable|exists:users,id',
            'nota_fiat' => 'nullable|string|max:255',
            'tanggal_fiat' => 'nullable|date',
            'sla' => 'nullable|date',
            'hari_pengerjaan' => 'nullable|integer',
            'status_pembayaran' => 'nullable|string|max:255',
            'tanggal_pembayaran' => 'nullable|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $rekapPembayaran = RekapPembayaran::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Rekap Pembayaran data successfully added!',
            'data' => $rekapPembayaran,
        ], 201);
    }

    public function update(Request $request, RekapPembayaran $rekapPembayaran)
    {
        $validated = $request->validate([
            'pic_pc_id' => 'nullable|exists:users,id',
            'tanggal_terima' => 'nullable|date',
            'nomor_spk' => 'required|string|max:255',
            'tanggal_spk' => 'required|date',
            'nomor_perjanjian' => 'nullable|string|max:255',
            'tanggal_perjanjian' => 'nullable|date',
            'perihal' => 'nullable|string|max:255',
            'spk' => 'nullable|json',
            'vendor' => 'nullable|string|max:255',
            'tkdn' => 'nullable|numeric',
            'nomor_invoice' => 'nullable|string|max:255',
            'invoice' => 'nullable|json',
            'nomor_rekening' => 'nullable|string|max:255',
            'pic_pay_id' => 'nullable|exists:users,id',
            'nota_fiat' => 'nullable|string|max:255',
            'tanggal_fiat' => 'nullable|date',
            'sla' => 'nullable|date',
            'hari_pengerjaan' => 'nullable|integer',
            'status_pembayaran' => 'nullable|string|max:255',
            'tanggal_pembayaran' => 'nullable|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $rekapPembayaran->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Rekap Pembayaran data successfully updated!',
            'data' => $rekapPembayaran,
        ], 200);
    }

    public function destroy(RekapPembayaran $rekapPembayaran)
    {
        $rekapPembayaran->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekap Pembayaran data successfully deleted!',
        ], 200);
    }
}
