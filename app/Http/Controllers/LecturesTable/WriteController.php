<?php

namespace App\Http\Controllers\LecturesTable;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\LectureState;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WriteController extends Controller
{
    public function addLecture(Request $request)
    {
        try {
            $validated = $request->validate([
                'topic_id' => 'required|integer|exists:syllabus,topic_id',
                'started_at' => 'nullable|date',
                'ended_at' => 'nullable|date|after_or_equal:started_at',
                'teacher_id' => 'required|integer|exists:teachers,teacher_id',
                'status' => 'nullable|in:activity,complete,broken,cancelled,ongoing,scheduled',
                'description' => 'nullable|string',

            ]);

            Lecture::create($validated);

            return redirect()->back();
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
