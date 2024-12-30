<?php

namespace App\Http\Controllers;

use App\Models\JatuhTempoDokumenSpk;
use Illuminate\Http\Request;

class JatuhTempoDokumenSpkController extends Controller
{
    /**
     * Display a listing of the jatuh tempo dokumen spk.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jatuhTempoDokumenSpk = JatuhTempoDokumenSpk::all();
        return response()->json($jatuhTempoDokumenSpk);
    }

    /**
     * Store a newly created jatuh tempo dokumen spk in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'keterangan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'dokumen_spk_id' => 'required|exists:dokumen_spks,id',
        ]);

        $jatuhTempoDokumenSpk = JatuhTempoDokumenSpk::create($validatedData);
        return response()->json($jatuhTempoDokumenSpk, 201);
    }

    /**
     * Update the specified jatuh tempo dokumen spk in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'keterangan' => 'sometimes|required|string|max:255',
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_akhir' => 'sometimes|required|date',
            'dokumen_spk_id' => 'sometimes|required|exists:dokumen_spks,id',
        ]);

        $jatuhTempoDokumenSpk = JatuhTempoDokumenSpk::findOrFail($id);
        $jatuhTempoDokumenSpk->update($validatedData);
        return response()->json($jatuhTempoDokumenSpk);
    }

    /**
     * Remove the specified jatuh tempo dokumen spk from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jatuhTempoDokumenSpk = JatuhTempoDokumenSpk::findOrFail($id);
        $jatuhTempoDokumenSpk->delete();
        return response()->json(null, 204);
    }
}
