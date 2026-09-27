<?php

namespace App\Http\Controllers\LecturesTable;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;

class ReadController extends Controller
{

    public function getLecturesByTopicId(Request $request)
    {
        $topicId = $request->input('topic_id');

        $lectures = Lecture::where('topic_id', $topicId)
            ->get();

        return response()->json($lectures);
    }

    public function getLecturesByTeacherId(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|integer|exists:teachers,teacher_id',
        ]);

        $lectures = Lecture::where('teacher_id', $validated['teacher_id'])
            ->get();

        return response()->json($lectures);
    }

    public function getLecturesByStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:activity,complete,broken,cancelled,ongoing,scheduled',
        ]);

        $lectures = Lecture::where('status', $validated['status'])
            ->get();

        return response()->json($lectures);
    }
}
