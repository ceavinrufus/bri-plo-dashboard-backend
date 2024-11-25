<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    public function index()
    {
        $data = HariLibur::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function store()
    {
        $validated = request()->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $hariLibur = HariLibur::create($validated);
        return response()->json([
            'status' => 'success',
            'message' => 'Hari libur data successfully added!',
            'data' => $hariLibur,
        ], 201);
    }

    public function update(Request $request, HariLibur $hariLibur)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $hariLibur->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Hari libur data successfully updated!',
            'data' => $hariLibur,
        ], 200);
    }

    public function destroy(HariLibur $hariLibur)
    {
        $hariLibur->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Hari libur data successfully deleted!',
        ], 200);
    }
}
