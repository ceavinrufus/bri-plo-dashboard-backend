<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:departments,code',
            'name' => 'required|string|max:255',
            'target' => 'required|numeric',
        ]);

        $department = Department::create($validatedData);
        return response()->json($department, 201);
    }

    /**
     * Display the specified department.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $department = Department::findOrFail($code);
        return response()->json($department);
    }

    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'target' => 'sometimes|required|numeric',
        ]);

        $department = Department::findOrFail($code);
        $department->update($validatedData);
        return response()->json($department);
    }

    /**
     * Remove the specified department from storage.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        $department = Department::findOrFail($code);
        $department->delete();
        return response()->json(null, 204);
    }
}
