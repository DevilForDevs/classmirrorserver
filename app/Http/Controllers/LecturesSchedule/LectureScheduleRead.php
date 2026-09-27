<?php

namespace App\Http\Controllers\LecturesSchedule;

use App\Http\Controllers\Controller;
use App\Models\LectureSchedule;
use Illuminate\Http\Request;

class LectureScheduleRead extends Controller
{
    public function getSchedule(Request $request)
    {
        $schedule = LectureSchedule::orderBy('day')
            ->orderBy('period')
            ->orderBy('start_time')
            ->get();

        return response()->json($schedule);
    }
}
