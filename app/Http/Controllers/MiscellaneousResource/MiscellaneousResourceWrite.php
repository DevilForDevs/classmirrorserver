<?php

namespace App\Http\Controllers\MiscellaneousResourcesTable;

use App\Http\Controllers\Controller;
use App\Models\MiscellaneousResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MiscellaneousResourceWrite extends Controller
{
    public function addResource(Request $request)
    {
        try {

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $resource = MiscellaneousResource::create($validated);

            return response()->json([
                'message' => 'Miscellaneous resource created successfully',

                'resource' => $resource
            ], 201);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Validation failed',

                'errors' => $e->errors()
            ], 422);
        }
    }

    public function get_resources()
    {
        $resources = MiscellaneousResource::leftJoin(
            'resources',
            'miscellaneous_resources.resource_id',
            '=',
            'resources.resource_id'
        )
            ->select(
                'miscellaneous_resources.*',
                'resources.title as resource_title',
                'resources.url as resource_url'
            )
            ->orderBy(
                'miscellaneous_resources.created_at',
                'desc'
            )
            ->get();

        return response()->json([
            'message' => 'Miscellaneous resources fetched successfully',
            'resources' => $resources
        ], 200);
    }
}
