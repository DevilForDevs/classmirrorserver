<?php

namespace App\Http\Controllers\LectureStatesTable;

use App\Http\Controllers\Controller;
use App\Models\LectureState;
use App\Models\Resource;
use Illuminate\Http\Request;

class LectureStateRead extends Controller
{
    public function getLectureStateByLectureId(Request $request)
    {
        $validated = $request->validate([
            'lecture_id' => 'required|integer|exists:lectures,lecture_id',
        ]);

        $lectureState = LectureState::where(
            'lecture_id',
            $validated['lecture_id']
        )->first();

        if (!$lectureState) {
            return response()->json([
                'message' => 'Lecture state not found',
            ], 404);
        }

        $lectureState->resources = Resource::where(
            'owner_table',
            'lecture_states'
        )
            ->where(
                'owner_row_id',
                $lectureState->lecture_state_id
            )
            ->get([
                'resource_id',
                'title',
                'url'
            ]);

        return response()->json($lectureState);
    }
}
