<?php

namespace App\Http\Controllers\SyllabusTable;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;


class SyllabusReadController extends Controller
{
    public function getByClassId(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,class_id',
        ]);

        $syllabus = Syllabus::where(
            'class_id',
            $request->class_id
        )
            ->orderBy('topic_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Syllabus fetched successfully',
            'syllabus' => $syllabus
        ], 200);
    }


    public function getByClassSubjectId(Request $request)
    {
        $request->validate([
            'class_subject_id' => 'required|integer|exists:class_subjects,class_subject_id',
        ]);

        $syllabus = Syllabus::where(
            'class_subject_id',
            $request->class_subject_id
        )
            ->orderBy('topic_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Syllabus fetched successfully',
            'syllabus' => $syllabus
        ], 200);
    }


    public function getByPaperId(Request $request)
    {
        $request->validate([
            'paper_id' => 'required|integer|exists:papers,paper_id',
        ]);

        $syllabus = Syllabus::where(
            'paper_id',
            $request->paper_id
        )
            ->orderBy('topic_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Syllabus fetched successfully',
            'syllabus' => $syllabus
        ], 200);
    }


    public function getByTeacherAndClassId(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|integer|exists:teachers,teacher_id',
            'class_id' => 'required|integer|exists:classes,class_id',
        ]);

        $syllabus = Syllabus::where(
            'teacher_id',
            $request->teacher_id
        )
            ->where(
                'class_id',
                $request->class_id
            )
            ->orderBy('topic_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Syllabus fetched successfully',
            'syllabus' => $syllabus
        ], 200);
    }


    public function getByClassIdAndSemester(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,class_id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $syllabus = Syllabus::where(
            'class_id',
            $request->class_id
        )
            ->where(
                'semester',
                $request->semester
            )
            ->orderBy('topic_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Syllabus fetched successfully',
            'syllabus' => $syllabus
        ], 200);
    }
}
