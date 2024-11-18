<?php

namespace App\Http\Controllers;

use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function show()
    {
        return view('employment_statuses.EmploymentStatus');
    }

    /**
     * Get all employment statuses.
     */
    public function getEmploymentStatuses()
    {
        $statuses = EmploymentStatus::all();
        return response()->json($statuses);
    }

    /**
     * Add a new employment status.
     */
    public function addEmploymentStatus(Request $request)
    {
        $request->validate([
            'StatusCategory' => 'required|string|max:255',
            'StatusName' => 'required|string|max:255',
            'StatusDescription' => 'nullable|string',
        ]);

        $status = EmploymentStatus::create([
            'StatusCategory' => $request->StatusCategory,
            'StatusName' => $request->StatusName,
            'StatusDescription' => $request->StatusDescription,
        ]);

        return response()->json(['success' => 'Employment status saved successfully.', 'status' => $status]);
    }

    /**
     * Get an employment status by ID.
     */
    public function getById($id)
    {
        $status = EmploymentStatus::find($id);
        
        if (!$status) {
            return response()->json(['error' => 'Employment status not found'], 404);
        }
        
        return response()->json($status);
    }

    /**
     * Update an employment status.
     */
    public function updateEmploymentStatus(Request $request, $id)
    {
        $status = EmploymentStatus::find($id);
        if (!$status) {
            return response()->json(['error' => 'Employment status not found'], 404);
        }

        $request->validate([
            'StatusCategory' => 'required|string|max:255',
            'StatusName' => 'required|string|max:255',
            'StatusDescription' => 'nullable|string',
        ]);

        $status->update([
            'StatusCategory' => $request->StatusCategory,
            'StatusName' => $request->StatusName,
            'StatusDescription' => $request->StatusDescription,
        ]);

        return response()->json(['success' => 'Employment status updated successfully.', 'status' => $status]);
    }

    /**
     * Delete an employment status.
     */
    public function deleteEmploymentStatus($id)
    {
        $status = EmploymentStatus::find($id);
        if (!$status) {
            return response()->json(['error' => 'Employment status not found'], 404);
        }

        $status->delete();
        return response()->json(['success' => 'Employment status deleted successfully']);
    }
}
