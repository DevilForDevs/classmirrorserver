<?php

namespace App\Http\Controllers\AnnouncemenTable;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementWrite extends Controller
{
    public function addAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'announcement' => 'required|string',
            'resource_id' => 'nullable|integer|exists:resources,resource_id',
        ]);

        $announcement = Announcement::create($validated);

        return response()->json([
            'message' => 'Announcement added successfully',
            'announcement' => $announcement,
        ], 201);
    }
}
