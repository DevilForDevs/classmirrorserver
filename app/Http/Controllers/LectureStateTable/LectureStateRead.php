<?php

namespace App\Http\Controllers\LectureStatesTable;

use App\Http\Controllers\Controller;
use App\Models\LectureState;
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

        return response()->json($lectureState);
    }
}
