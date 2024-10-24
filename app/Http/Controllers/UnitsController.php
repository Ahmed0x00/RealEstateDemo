<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    // 1. Get all units
    public function getAllUnits()
    {
        $units = Unit::all();
        $totalUnits = $units->count();

        return response()->json([
            'totalUnits' => $totalUnits,
            'units' => $units
        ]);
    }

    // 2. Get specific unit by ID
    public function getUnitById($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            return response()->json($unit);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }

    // 3. Create a new unit
    public function createUnit(Request $request)
    {
        // Validate the request
        $request->validate([
            'code' => 'required|string|unique:units',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // Create the unit
        $unit = Unit::create($request->all());

        return response()->json([
            'message' => 'Unit created successfully',
            'unit' => $unit
        ]);
    }

    // 4. Update a unit
    public function updateUnit(Request $request, $id)
    {
        try {
            // Find the unit by id
            $unit = Unit::findOrFail($id);

            // Validate the request
            $request->validate([
                'code' => 'required|string|unique:units,code,' . $unit->id, // Ensure code uniqueness except current unit
                'area' => 'required',
                'price' => 'required',
            ]);

            // Update the unit
            $unit->update($request->all());

            return response()->json([
                'message' => 'Unit updated successfully',
                'unit' => $unit
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }

    // 5. Delete a unit
    public function deleteUnit($id)
    {
        try {
            // Find the unit by id
            $unit = Unit::findOrFail($id);

            // Delete the unit
            $unit->delete();

            return response()->json(['message' => 'Unit deleted successfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }
}
