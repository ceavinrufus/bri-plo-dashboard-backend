<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapPembayaran;
use Illuminate\Support\Facades\Log;

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
            'sla' => 'nullable|string|max:255',
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
            'sla' => 'nullable|string|max:255',
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
