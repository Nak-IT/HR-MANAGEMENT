<?php

namespace App\Http\Controllers;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $provinces = Province::all();
    //     return view('provinces.province', compact('provinces'));
    // }
    public function show()
    {
        return view('provinces.province');
    }
    /**
     * Get all provinces.
     */
    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    /**
     * Add a new province.
     */
    public function addProvince(Request $request)
    {
        $request->validate([
            'ProvinceName' => 'required|string|max:255',
        ]);

        $province = Province::create([
            'ProvinceName' => $request->ProvinceName,
        ]);

        return response()->json(['success' => 'Province saved successfully.', 'province' => $province]);
    }

    /**
     * Get a province by ID.
     */
    public function getById($id)
    {
        $province = Province::find($id);
        if (!$province) {
            return response()->json(['error' => 'Province not found'], 404);
        }
        return response()->json($province);
    }

    /**
     * Update a province.
     */
    public function updateProvince(Request $request, $id)
    {
        $province = Province::find($id);
        if (!$province) {
            return response()->json(['error' => 'Province not found'], 404);
        }

        $request->validate([
            'ProvinceName' => 'required|string|max:255',
        ]);

        $province->update([
            'ProvinceName' => $request->ProvinceName,
        ]);

        return response()->json(['success' => 'Province updated successfully.', 'province' => $province]);
    }

    /**
     * Delete a province.
     */
    public function deleteProvince($id)
    {
        $province = Province::find($id);
        if (!$province) {
            return response()->json(['error' => 'Province not found'], 404);
        }

        $province->delete();
        return response()->json(['success' => 'Province deleted successfully']);
    }
}
