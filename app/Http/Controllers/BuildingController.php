<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function show()
    {
        return view('buildings.Building');
    }

    /**
     * Get all buildings.
     */
    public function getBuildings()
    {
        $buildings = Building::all();
        return response()->json($buildings);
    }

    /**
     * Add a new building.
     */
    public function addBuilding(Request $request)
    {
        $request->validate([
            'BuildingName' => 'required|string|max:255',
        ]);

        $building = Building::create([
            'BuildingName' => $request->BuildingName,
        ]);

        return response()->json(['success' => 'Building saved successfully.', 'building' => $building]);
    }

    /**
     * Get a building by ID.
     */
    public function getById($id)
    {
        $building = Building::find($id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }
        return response()->json($building);
    }

    /**
     * Update a building.
     */
    public function updateBuilding(Request $request, $id)
    {
        $building = Building::find($id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        $request->validate([
            'BuildingName' => 'required|string|max:255',
        ]);

        $building->update([
            'BuildingName' => $request->BuildingName,
        ]);

        return response()->json(['success' => 'Building updated successfully.', 'building' => $building]);
    }

    /**
     * Delete a building.
     */
    public function deleteBuilding($id)
    {
        $building = Building::find($id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        $building->delete();
        return response()->json(['success' => 'Building deleted successfully']);
    }
}
