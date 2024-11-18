<?php

namespace App\Http\Controllers;

use App\Models\CategoryEmployee;
use Illuminate\Http\Request;

class CategoryEmployeeController extends Controller
{
    public function show()
    {
        return view('category_employees.CategoryEmployee');
    }

    /**
     * Get all category employees.
     */
    public function getCategoryEmployees()
    {
        $categoryEmployees = CategoryEmployee::all();
        return response()->json($categoryEmployees);
    }

    /**
     * Add a new category employee.
     */
    public function addCategoryEmployee(Request $request)
    {
        $request->validate([
            'CategoryEmployeeName' => 'required|string|max:255',
        ]);

        $categoryEmployee = CategoryEmployee::create([
            'CategoryEmployeeName' => $request->CategoryEmployeeName,
        ]);

        return response()->json(['success' => 'Category Employee saved successfully.', 'categoryEmployee' => $categoryEmployee]);
    }

    /**
     * Get a category employee by ID.
     */
    public function getById($id)
    {
        $categoryEmployee = CategoryEmployee::find($id);
        if (!$categoryEmployee) {
            return response()->json(['error' => 'Category Employee not found'], 404);
        }
        return response()->json($categoryEmployee);
    }

    /**
     * Update a category employee.
     */
    public function updateCategoryEmployee(Request $request, $id)
    {
        $categoryEmployee = CategoryEmployee::find($id);
        if (!$categoryEmployee) {
            return response()->json(['error' => 'Category Employee not found'], 404);
        }

        $request->validate([
            'CategoryEmployeeName' => 'required|string|max:255',
        ]);

        $categoryEmployee->update([
            'CategoryEmployeeName' => $request->CategoryEmployeeName,
        ]);

        return response()->json(['success' => 'Category Employee updated successfully.', 'categoryEmployee' => $categoryEmployee]);
    }

    /**
     * Delete a category employee.
     */
    public function deleteCategoryEmployee($id)
    {
        $categoryEmployee = CategoryEmployee::find($id);
        if (!$categoryEmployee) {
            return response()->json(['error' => 'Category Employee not found'], 404);
        }

        $categoryEmployee->delete();
        return response()->json(['success' => 'Category Employee deleted successfully']);
    }
}
