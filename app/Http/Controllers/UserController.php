<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Fetch data from the Pengadaan model based on the departemen
        $data = User::all();

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    /**
     * Get the authenticated user.
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }
}
