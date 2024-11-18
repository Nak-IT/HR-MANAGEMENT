<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function show()
    {
        return view('departments.department');
    }

    /**
     * Get all departments.
     */


    public function getDepartments()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    /**
     * Add a new department.
     */
    public function addDepartment(Request $request)
    {
        $request->validate([
            'DepartmentName' => 'required|string|max:255',
        ]);

        $department = Department::create([
            'DepartmentName' => $request->DepartmentName,
        ]);

        return response()->json(['success' => 'Department saved successfully.', 'department' => $department]);
    }

    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'DepartmentName' => 'required|string|max:255',
        ]);

        $department = Department::findOrFail($id);
        $department->DepartmentName = $request->DepartmentName;
        $department->save();

        return response()->json(['success' => 'Department updated successfully.', 'department' => $department]);
    }

    /**
     * Get a department by ID.
     */
    public function getById($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        return response()->json($department);
    }

    /**
     * Update a department.
     */


    /**
     * Delete a department.
     */
    public function deleteDepartment($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $department->delete();
        return response()->json(['success' => 'Department deleted successfully']);
    }
}
