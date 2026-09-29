<?php

namespace App\Http\Controllers\LecturesSchedule;

use App\Http\Controllers\Controller;
use App\Models\LectureSchedule;
use Illuminate\Http\Request;

class LectureScheduleRead extends Controller
{
    public function getSchedule(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,class_id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $schedule = LectureSchedule::where(
            'class_id',
            $request->class_id
        )
            ->where(
                'semester',
                $request->semester
            )
            ->orderBy('day')
            ->orderBy('period')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'message' => 'Lecture schedule fetched successfully',
            'schedule' => $schedule
        ], 200);
    }
}
