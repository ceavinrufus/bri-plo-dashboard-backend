<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\NodinPlo;
use App\Models\NodinUser;
use Illuminate\Http\Request;

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

            // Remove unwanted fields
            unset($itemArray['id']);
            unset($itemArray['departemen']);
            unset($itemArray['created_at']);
            unset($itemArray['updated_at']);

            // Place 'nomor' at the start
            $itemArray = array_merge(['nomor' => $index + 1], $itemArray);
            $itemArray['nodin_plo'] = $item->nodinPlos;
            $itemArray['nodin_user'] = $item->nodinUsers;

            return $itemArray;
        });

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
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
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukkan Langsung',
            'is_verification_complete' => 'nullable|boolean',
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
        ]);

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

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully added!',
            'data' => $pengadaan->load(['nodinPlos', 'nodinUsers']), // Load related nodinPlos and nodinUsers
        ], 201);
    }

    // Function to update Pengadaan and related nodin_plos
    public function update(Request $request, Pengadaan $pengadaan)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode_user' => 'nullable|string|max:255',
            'tim' => 'nullable|string|max:3',
            'departemen' => 'nullable|exists:departments,code',
            'perihal' => 'nullable|string|max:255',
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukkan Langsung',
            'is_verification_complete' => 'nullable|boolean',
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
        ]);

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

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully updated!',
            'data' => $pengadaan->load(['nodinPlos', 'nodinUsers']), // Load related nodinPlos
        ], 200);
    }

    // Function to delete Pengadaan and related NodinPlos
    public function destroy(Pengadaan $pengadaan)
    {
        // Delete associated NodinUsers & NodinPlos
        $pengadaan->nodinUsers()->delete();
        $pengadaan->nodinPlos()->delete();

        // Delete the Pengadaan record
        $pengadaan->delete();

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully deleted!',
        ], 200);
    }
}
