<?php

namespace App\Http\Controllers\LectureStatesTable;

use App\Http\Controllers\Controller;
use App\Models\LectureState;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class LectureStateWrite extends Controller
{
    public function addLectureState(Request $request)
    {
        try {
            $validated = $request->validate([
                'lecture_id' => 'required|integer|exists:lectures,lecture_id',
                'questions' => 'nullable|string',
                'major_statements' => 'nullable|string',
                'minor_statements' => 'nullable|string',
                'mention_of_persons' => 'nullable|string',
                'mention_of_creations' => 'nullable|string',
                'declarations' => 'nullable|string',
                'all_statements' => 'nullable|string',
                'image_urls' => 'nullable|string',
            ]);

            $lectureState = LectureState::create($validated);

            return response()->json($lectureState, 201);
        } catch (Exception $e) {
            Log::error('Failed To Statements: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed To Statements',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
