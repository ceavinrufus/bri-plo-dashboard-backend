<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Function to return data based on project
    public function index()
    {
        // Fetch data from the Pengadaan model based on the project
        $data = Project::all();

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }

    // Function to store data and related nodin_plos and return a JSON response
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        // Create a new Project record
        $project = Project::create($validated);

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Project data successfully added!',
            'data' => $project,
        ], 201);
    }

    // Function to update Project and related pengadaan
    public function update(Request $request, Project $project)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        // Update the Project record with validated data
        $project->update($validated);

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Project data successfully updated!',
            'data' => $project,
        ], 200);
    }

    // Function to delete Project and related Pengadaan
    public function destroy(Project $project)
    {
        // Delete associated Pengadaan and their NodinPlos
        foreach ($project->pengadaan as $pengadaan) {
            $pengadaan->nodinPlos()->delete();
            $pengadaan->delete();
        }

        // Delete the Project record
        $project->delete();

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Project data successfully deleted!',
        ], 200);
    }
}
