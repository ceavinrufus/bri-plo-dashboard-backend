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
            'departemen' => 'required|in:bcp,igp,psr',
            'nama_pengadaan' => 'required|string|max:255',
            'tanggal_nodin' => 'nullable|date',
            'tanggal_spk' => 'nullable|date',
            'hari_pengerjaan' => 'nullable|integer',
            'metode' => 'nullable|in:Pemilihan Langsung,Penunjukkan Langsung,Lelang',
            'progres' => 'nullable|string|max:255',
            'hari_proses' => 'nullable|integer',
            'progres_pengadaan' => 'nullable|string|max:255',
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
}
