<?php

namespace App\Http\Controllers\LecturesTable;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureReadController extends Controller
{

    public function getLecturesByClassId(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,class_id',
        ]);

        $lectures = Lecture::where(
            'class_id',
            $request->class_id
        )
            ->orderBy('started_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Lectures fetched successfully',
            'lectures' => $lectures
        ], 200);
    }



    public function getLecturesByClassSubject(Request $request)
    {
        $request->validate([
            'class_subject_id' => 'required|integer|exists:class_subjects,class_subject_id',
        ]);

        $lectures = Lecture::where(
            'class_subject_id',
            $request->class_subject_id
        )
            ->orderBy('started_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Lectures fetched successfully',
            'lectures' => $lectures
        ], 200);
    }

    public function getByTeacherAndClassSubjectId(Request $request)
    {
        $request->validate([
            'class_subject_id' => 'required|integer|exists:class_subjects,class_subject_id',
            'teacher_id' => 'nullable|integer|exists:teachers,teacher_id',
        ]);

        $query = Lecture::where(
            'class_subject_id',
            $request->class_subject_id
        );

        if ($request->filled('teacher_id')) {
            $query->where(
                'teacher_id',
                $request->teacher_id
            );
        }

        $lectures = $query
            ->orderBy('started_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Lectures fetched successfully',
            'lectures' => $lectures
        ], 200);
    }
}
