<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    // 1. Get all resources
    public function getAllResources()
    {
        $resources = Resource::all();
        $totalResources = $resources->count();

        return response()->json([
            'totalResources' => $totalResources,
            'resources' => $resources
        ]);
    }

    // 2. Get specific resource by ID
    public function getResourceById($id)
    {
        try {
            $resource = Resource::findOrFail($id);
            return response()->json($resource);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }

    // 3. Create a new resource
    public function createResource(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $resource = Resource::create($request->all());

        return response()->json([
            'message' => 'Resource created successfully',
            'resource' => $resource
        ]);
    }

    // 4. Update a resource
    public function updateResource(Request $request, $id)
    {
        try {
            $resource = Resource::findOrFail($id);
            $request->validate([
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
            ]);

            $resource->update($request->all());

            return response()->json([
                'message' => 'Resource updated successfully',
                'resource' => $resource
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }

    // 5. Delete a resource
    public function deleteResource($id)
    {
        try {
            $resource = Resource::findOrFail($id);
            $resource->delete();

            return response()->json(['message' => 'Resource deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}
