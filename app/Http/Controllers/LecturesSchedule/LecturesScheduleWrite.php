<?php

namespace App\Http\Controllers\LecturesSchedule;

use App\Http\Controllers\Controller;
use App\Models\LectureSchedule;
use Illuminate\Http\Request;

class LecturesScheduleWrite extends Controller
{
    public function addSchedule(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'period' => 'nullable|integer',
            'teacher_id' => 'required|integer|exists:teachers,teacher_id',
        ]);

        LectureSchedule::create($validated);

        return redirect()->back()
            ->with('success', 'Lecture schedule added successfully.');
    }
}
