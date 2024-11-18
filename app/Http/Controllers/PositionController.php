<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function show()
    {
        return view('positions.position');
    }

    /**
     * Get all positions.
     */
    public function getPositions()
    {
        $positions = Position::all();
        return response()->json($positions);
    }

    /**
     * Add a new position.
     */
    public function addPosition(Request $request)
    {
        $request->validate([
            'PositionName' => 'required|string|max:255',
        ]);

        $position = Position::create([
            'PositionName' => $request->PositionName,
        ]);

        return response()->json(['success' => 'Position saved successfully.', 'position' => $position]);
    }

    /**
     * Get a position by ID.
     */
    public function getById($id)
    {
        $position = Position::find($id);
        
        if (!$position) {
            return response()->json(['error' => 'Position not found'], 404);
        }
        
        return response()->json($position);
    }

    /**
     * Update a position.
     */
    public function updatePosition(Request $request, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['error' => 'Position not found'], 404);
        }

        $request->validate([
            'PositionName' => 'required|string|max:255',
        ]);

        $position->update([
            'PositionName' => $request->PositionName,
        ]);

        return response()->json(['success' => 'Position updated successfully.', 'position' => $position]);
    }

    /**
     * Delete a position.
     */
    public function deletePosition($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['error' => 'Position not found'], 404);
        }

        $position->delete();
        return response()->json(['success' => 'Position deleted successfully']);
    }
}
