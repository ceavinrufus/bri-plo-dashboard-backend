<?php

namespace App\Http\Controllers;

use App\Models\NodinIpPengadaan;
use App\Models\Pengadaan;
use App\Models\NodinPlo;
use App\Models\NodinUser;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PengadaanController extends Controller
{
    // Function to return data based on departemen
    public function index(Pengadaan $pengadaan)
    {
        // Fetch data from the Pengadaan model based on the departemen
        $data = Pengadaan::where('departemen', $pengadaan->departemen)->get();

        // Modify data to add 'nomor' field and remove unwanted fields
        $data = $data->map(function ($item, $index) {
            // Convert the item to an array
            $itemArray = $item->toArray();

            // Place 'nomor' at the start
            $itemArray['nodin_plos'] = $item->nodinPlos;
            $itemArray['nodin_ip_pengadaans'] = $item->nodinIpPengadaans;
            $itemArray['nodin_users'] = $item->nodinUsers;

            return $itemArray;
        });

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function getByNomorSpk(Request $request)
    {
        // Get nomor_spk from query parameters
        $nomor_spk = $request->query('nomor_spk');

        // If no nomor_spk is provided, return an error
        if (!$nomor_spk) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor SPK is required.',
            ], 400);
        }

        // Retrieve the Pengadaan record based on the unique nomor_spk
        $pengadaan = Pengadaan::where('nomor_spk', $nomor_spk)->first();

        // If the Pengadaan record is not found, return an error response
        if (!$pengadaan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengadaan data not found for the provided nomor_spk.',
            ], 404);
        }

        // Return the Pengadaan data along with the related nodins (NodinPlos, NodinUsers, NodinIpPengadaans)
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data fetched successfully.',
            'data' => $pengadaan->load(['nodinPlos', 'nodinUsers', 'nodinIpPengadaans']),
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

                    // Prepare Pengadaan data
                    $pengadaanData = [
                        'kode_user' => $data['kode_user'] ?? null,
                        'tim' => $data['tim'] ?? null,
                        'departemen' => $data['departemen'],
                        'perihal' => $data['perihal'] ?? null,
                        'metode' => $data['metode'] ?? null,
                        'proses_pengadaan' => $data['proses_pengadaan'] ?? null,
                        'nodin_ip_pengadaans' => empty($data['nodin_ip_pengadaan']) || empty($data['tanggal_nodin_ip_pengadaan']) ? [] : collect(explode(';', $data['nodin_ip_pengadaan']))
                            ->map(function ($nodin, $index) use ($data) {
                                $tanggalNodin = explode(';', $data['tanggal_nodin_ip_pengadaan'])[$index] ?? '';
                                return [
                                    'nodin' => $nodin,
                                    'tanggal_nodin' => $this->parseExcelDate($tanggalNodin)
                                ];
                            })->toArray(),
                        'nodin_users' => empty($data['nodin_user']) || empty($data['tanggal_nodin_user']) ? [] : collect(explode(';', $data['nodin_user']))
                            ->map(function ($nodin, $index) use ($data) {
                                $tanggalNodin = explode(';', $data['tanggal_nodin_user'])[$index] ?? '';
                                return [
                                    'nodin' => $nodin,
                                    'tanggal_nodin' => $this->parseExcelDate($tanggalNodin)
                                ];
                            })->toArray(),
                        'nodin_plos' => empty($data['nodin_plo']) || empty($data['tanggal_nodin_plo']) ? [] : collect(explode(';', $data['nodin_plo']))
                            ->map(function ($nodin, $index) use ($data) {
                                $tanggalNodin = explode(';', $data['tanggal_nodin_plo'])[$index] ?? '';
                                return [
                                    'nodin' => $nodin,
                                    'tanggal_nodin' => $this->parseExcelDate($tanggalNodin)
                                ];
                            })->toArray(),
                        'nomor_spk' => $data['nomor_spk'] ?? null,
                        'tanggal_spk' => $this->parseExcelDate($data['tanggal_spk'] ?? null),
                        'verification_completed_at' => $this->parseExcelDate($data['tanggal_dokumen_lengkap'] ?? null),
                        'tanggal_acuan' => $this->parseExcelDate($data['tanggal_spph'] ?? null),
                        'spk_investasi' => 'nullable|json',
                        'spk_eksploitasi' => 'nullable|json',
                        'anggaran_investasi' => 'nullable|json',
                        'anggaran_eksploitasi' => 'nullable|json',
                        'hps' => 'nullable|json',
                        'spk_investasi' => json_encode([
                            'currency' => $data['currency_spk_investasi'] ?? null,
                            'amount' => isset($data['nilai_spk_investasi']) ? (float)$data['nilai_spk_investasi'] : null ?? null,
                            'rate' => isset($data['rate_spk_investasi']) ? (float)$data['rate_spk_investasi'] : null ?? null,
                        ]),
                        'spk_eksploitasi' => json_encode([
                            'currency' => $data['currency_spk_eksploitasi'] ?? null,
                            'amount' => isset($data['nilai_spk_eksploitasi']) ? (float)$data['nilai_spk_eksploitasi'] : null,
                            'rate' => isset($data['rate_spk_eksploitasi']) ? (float)$data['rate_spk_eksploitasi'] : null,
                        ]),
                        'anggaran_investasi' => json_encode([
                            'currency' => $data['currency_anggaran_investasi'] ?? null,
                            'amount' => isset($data['nilai_anggaran_investasi']) ? (float)$data['nilai_anggaran_investasi'] : null,
                            'rate' => isset($data['rate_anggaran_investasi']) ? (float)$data['rate_anggaran_investasi'] : null,
                        ]),
                        'anggaran_eksploitasi' => json_encode([
                            'currency' => $data['currency_anggaran_eksploitasi'] ?? null,
                            'amount' => isset($data['nilai_anggaran_eksploitasi']) ? (float)$data['nilai_anggaran_eksploitasi'] : null,
                            'rate' => isset($data['rate_anggaran_eksploitasi']) ? (float)$data['rate_anggaran_eksploitasi'] : null,
                        ]),
                        'hps' => json_encode([
                            'currency' => $data['currency_hps'] ?? null,
                            'amount' => isset($data['nilai_hps']) ? (float)$data['nilai_hps'] : null,
                            'rate' => isset($data['rate_hps']) ? (float)$data['rate_hps'] : null,
                        ]),
                        'pelaksana_pekerjaan' => $data['pelaksana_pekerjaan'] ?? null,
                        'tkdn_percentage' => $data['tkdn_percentage'] ?? null,
                        'catatan' => $data['catatan'] ?? null,
                        'proyek' => $data['proyek'] ?? null,
                    ];

                    // Create a new Pengadaan record
                    try {
                        $pengadaan = Pengadaan::create($pengadaanData);
                    } catch (\Exception $e) {
                        Log::error('Failed to create Pengadaan: ' . $e->getMessage());
                        throw new \Exception('Failed to create Pengadaan: ' . $e->getMessage());
                    }

                    // Create associated NodinUsers if present
                    if (isset($pengadaanData['nodin_users'])) {
                        foreach ($pengadaanData['nodin_users'] as $nodinUserData) {
                            try {
                                $pengadaan->nodinUsers()->create($nodinUserData);
                            } catch (\Exception $e) {
                                Log::error('Failed to create NodinUser: ' . $e->getMessage());
                                throw new \Exception('Failed to create NodinUser: ' . $e->getMessage());
                            }
                        }
                    }

                    // Create associated NodinPlos if present
                    if (isset($pengadaanData['nodin_plos'])) {
                        foreach ($pengadaanData['nodin_plos'] as $nodinPloData) {
                            try {
                                $pengadaan->nodinPlos()->create($nodinPloData);
                            } catch (\Exception $e) {
                                Log::error('Failed to create NodinPlo: ' . $e->getMessage());
                                throw new \Exception('Failed to create NodinPlo: ' . $e->getMessage());
                            }
                        }
                    }

                    // Create associated NodinIpPengadaans if present
                    if (isset($pengadaanData['nodin_ip_pengadaans'])) {
                        foreach ($pengadaanData['nodin_ip_pengadaans'] as $nodinIpPengadaanData) {
                            try {
                                $pengadaan->nodinIpPengadaans()->create($nodinIpPengadaanData);
                            } catch (\Exception $e) {
                                Log::error('Failed to create NodinIpPengadaan: ' . $e->getMessage());
                                throw new \Exception('Failed to create NodinIpPengadaan: ' . $e->getMessage());
                            }
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

    private function parseExcelDate($value)
    {
        if (empty($value)) return null;

        try {
            // If it's a numeric value (Excel date)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }

            // If it's already a date string, try to parse it
            return date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }

    // Function to store data and related nodin_users & nodin_plos and return a JSON response
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode_user' => 'required|string|max:255',
            'tim' => 'required|string|max:3',
            'departemen' => 'required|exists:departments,code',
            'perihal' => 'required|string|max:255',
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukan Langsung',
            'verification_completed_at' => 'nullable|date',
            'verification_alert_at' => 'nullable|date',
            'nodin_alert_at' => 'nullable|date',
            'pic_id' => 'required|exists:users,id',
            'proses_pengadaan' => 'nullable|string|max:255',
            'pengadaan_log' => 'nullable|array',
            'nomor_spk' => 'nullable|string|max:255',
            'tanggal_spk' => 'nullable|date',
            'tanggal_acuan' => 'nullable|date',
            'pelaksana_pekerjaan' => 'nullable|string|max:255',
            'spk_investasi' => 'nullable|json',
            'spk_eksploitasi' => 'nullable|json',
            'anggaran_investasi' => 'nullable|json',
            'anggaran_eksploitasi' => 'nullable|json',
            'hps' => 'nullable|json',
            'tkdn_percentage' => 'nullable|numeric',
            'catatan' => 'nullable|string|max:255',
            'proyek' => 'nullable|string|max:255', // Kode proyek
            'nodin_users' => 'nullable|array', // Nodin User must be an array
            'nodin_users.*.nodin' => 'required_with:nodin_users|string|max:255',
            'nodin_users.*.tanggal_nodin' => 'required_with:nodin_users|date',
            'nodin_plos' => 'nullable|array', // Nodin Plo must be an array
            'nodin_plos.*.nodin' => 'required_with:nodin_plos|string|max:255',
            'nodin_plos.*.tanggal_nodin' => 'required_with:nodin_plos|date',
            'nodin_ip_pengadaans' => 'nullable|array', // Nodin IP Pengadaan must be an array
            'nodin_ip_pengadaans.*.nodin' => 'required_with:nodin_ip_pengadaans|string|max:255',
            'nodin_ip_pengadaans.*.tanggal_nodin' => 'required_with:nodin_ip_pengadaans|date',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new Pengadaan record
            $pengadaan = Pengadaan::create($validated);

            // Create associated NodinUsers if present
            if (isset($validated['nodin_users'])) {
                foreach ($validated['nodin_users'] as $nodinUserData) {
                    $pengadaan->nodinUsers()->create($nodinUserData);
                }
            }

            // Create associated NodinPlos if present
            if (isset($validated['nodin_plos'])) {
                foreach ($validated['nodin_plos'] as $nodinPloData) {
                    $pengadaan->nodinPlos()->create($nodinPloData);
                }
            }

            // Create associated NodinIpPengadaans if present
            if (isset($validated['nodin_ip_pengadaans'])) {
                foreach ($validated['nodin_ip_pengadaans'] as $nodinIpPengadaanData) {
                    $pengadaan->nodinIpPengadaans()->create($nodinIpPengadaanData);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Pengadaan data successfully added!',
                'data' => $pengadaan->load(['nodinPlos', 'nodinUsers', 'nodinIpPengadaans']), // Load related nodinPlos, nodinUsers, and nodinIpPengadaans
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();

            // Return a JSON response indicating failure
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Pengadaan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Function to update Pengadaan and related nodins
    public function update(Request $request, Pengadaan $pengadaan)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode_user' => 'nullable|string|max:255',
            'tim' => 'nullable|string|max:3',
            'departemen' => 'nullable|exists:departments,code',
            'perihal' => 'nullable|string|max:255',
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukan Langsung',
            'verification_completed_at' => 'nullable|date',
            'verification_alert_at' => 'nullable|date',
            'nodin_alert_at' => 'nullable|date',
            'pic_id' => 'nullable|exists:users,id',
            'proses_pengadaan' => 'nullable|string|max:255',
            'pengadaan_log' => 'nullable|array',
            'nomor_spk' => 'nullable|string|max:255',
            'tanggal_spk' => 'nullable|date',
            'tanggal_acuan' => 'nullable|date',
            'pelaksana_pekerjaan' => 'nullable|string|max:255',
            'spk_investasi' => 'nullable|json',
            'spk_eksploitasi' => 'nullable|json',
            'anggaran_investasi' => 'nullable|json',
            'anggaran_eksploitasi' => 'nullable|json',
            'hps' => 'nullable|json',
            'tkdn_percentage' => 'nullable|numeric',
            'catatan' => 'nullable|string|max:255',
            'proyek' => 'nullable|string|max:255', // Kode proyek
            'nodin_users' => 'nullable|array', // Nodin User must be an array
            'nodin_users.*.id' => 'nullable|exists:nodin_users,id', // Allow existing NodinUser for update
            'nodin_users.*.nodin' => 'required_with:nodin_users|string|max:255',
            'nodin_users.*.tanggal_nodin' => 'required_with:nodin_users|date',
            'nodin_plos' => 'nullable|array', // Nodin Plo must be an array
            'nodin_plos.*.id' => 'nullable|exists:nodin_plos,id', // Allow existing NodinPlo for update
            'nodin_plos.*.nodin' => 'required_with:nodin_plos|string|max:255',
            'nodin_plos.*.tanggal_nodin' => 'required_with:nodin_plos|date',
            'nodin_ip_pengadaans' => 'nullable|array', // Nodin IP pengadaan must be an array
            'nodin_ip_pengadaans.*.id' => 'nullable|exists:nodin_ip_pengadaans,id', // Allow existing NodinIpPengadaan for update
            'nodin_ip_pengadaans.*.nodin' => 'required_with:nodin_ip_pengadaans|string|max:255',
            'nodin_ip_pengadaans.*.tanggal_nodin' => 'required_with:nodin_ip_pengadaans|date',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update the Pengadaan record with validated data
            $pengadaan->update($validated);

            // Sync NodinUsers if present
            if (isset($validated['nodin_users'])) {
                foreach ($validated['nodin_users'] as $nodinUserData) {
                    if (isset($nodinUserData['id'])) {
                        // Update existing NodinUser
                        NodinUser::where('id', $nodinUserData['id'])->update($nodinUserData);
                    } else {
                        // Create a new NodinUser
                        $pengadaan->nodinUsers()->create($nodinUserData);
                    }
                }
            }

            // Sync NodinPlos if present
            if (isset($validated['nodin_plos'])) {
                foreach ($validated['nodin_plos'] as $nodinPloData) {
                    if (isset($nodinPloData['id'])) {
                        // Update existing NodinPlo
                        NodinPlo::where('id', $nodinPloData['id'])->update($nodinPloData);
                    } else {
                        // Create a new NodinPlo
                        $pengadaan->nodinPlos()->create($nodinPloData);
                    }
                }
            }

            // Sync NodinIpPengadaans if present
            if (isset($validated['nodin_ip_pengadaans'])) {
                foreach ($validated['nodin_ip_pengadaans'] as $nodinIpPengadaanData) {
                    if (isset($nodinIpPengadaanData['id'])) {
                        // Update existing NodinIpPengadaan
                        NodinIpPengadaan::where('id', $nodinIpPengadaanData['id'])->update($nodinIpPengadaanData);
                    } else {
                        // Create a new NodinIpPengadaan
                        $pengadaan->nodinIpPengadaans()->create($nodinIpPengadaanData);
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Pengadaan data successfully updated!',
                'data' => $pengadaan->load(['nodinPlos', 'nodinUsers', 'nodinIpPengadaans']), // Load related nodinPlos, nodinUsers, and nodinIpPengadaans
            ], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();

            // Return a JSON response indicating failure
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Pengadaan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Function to delete Pengadaan and related NodinPlos, NodinUsers, and NodinIpPengadaans
    public function destroy(Pengadaan $pengadaan)
    {
        // Delete associated NodinUsers, NodinPlos, and NodinIpPengadaans
        $pengadaan->nodinUsers()->delete();
        $pengadaan->nodinPlos()->delete();
        $pengadaan->nodinIpPengadaans()->delete();

        // Delete the Pengadaan record
        $pengadaan->delete();

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully deleted!',
        ], 200);
    }
}
