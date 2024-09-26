<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
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

            return $itemArray;
        });

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    // Function to store data and return a JSON response
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode_user' => 'required|string|max:255',
            'nodin_user' => 'nullable|string|max:255',
            'tanggal_nodin_user' => 'nullable|date',
            'tim' => 'required|string|max:3',
            'departemen' => 'required|exists:departments,code',
            'perihal' => 'required|string|max:255',
            'tanggal_spk' => 'nullable|date',
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukkan Langsung',
            'is_verification_complete' => 'nullable|boolean',
            'verification_alert_at' => 'nullable|date',
            'nodin_alert_at' => 'nullable|date',
            'is_done' => 'nullable|boolean',
            'proses_pengadaan' => 'nullable|string|max:255',
            'nilai_spk' => 'nullable|integer',
            'anggaran' => 'nullable|integer',
            'hps' => 'nullable|integer',
            'tkdn_percentage' => 'nullable|integer',
            'catatan' => 'nullable|string|max:255',
        ]);

        // Create a new Pengadaan record
        $pengadaan = Pengadaan::create($validated);

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully added!',
            'data' => $pengadaan,
        ], 201);
    }

    public function update(Request $request, Pengadaan $pengadaan)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode_user' => 'required|string|max:255',
            'nodin_user' => 'nullable|string|max:255',
            'tanggal_nodin_user' => 'nullable|date',
            'tim' => 'required|string|max:3',
            'departemen' => 'required|exists:departments,code',
            'perihal' => 'required|string|max:255',
            'tanggal_spk' => 'nullable|date',
            'metode' => 'nullable|in:Lelang,Pemilihan Langsung,Seleksi Langsung,Penunjukkan Langsung',
            'is_verification_complete' => 'nullable|boolean',
            'verification_alert_at' => 'nullable|date',
            'nodin_alert_at' => 'nullable|date',
            'is_done' => 'nullable|boolean',
            'proses_pengadaan' => 'nullable|string|max:255',
            'nilai_spk' => 'nullable|integer',
            'anggaran' => 'nullable|integer',
            'hps' => 'nullable|integer',
            'tkdn_percentage' => 'nullable|integer',
            'catatan' => 'nullable|string|max:255',
        ]);

        // Update the Pengadaan record with validated data
        $pengadaan->update($validated);

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Pengadaan data successfully updated!',
            'data' => $pengadaan,
        ], 200);
    }
}
