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
     * Get users by tim.
     */
    public function getUsersByTeam($tim)
    {
        // Fetch users based on the `tim` parameter
        $users = User::where('tim', $tim)->get();

        // Return the users as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Users fetched successfully',
            'data' => $users,
        ], 200);
    }


    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'pn' => 'sometimes|string|max:255',
            'departemen' => 'sometimes|string|max:255',
            'tim' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|max:255',
        ]);

        // Update the user with the validated data
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
        $user->update($validatedData);

        // Return the updated user as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user,
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
