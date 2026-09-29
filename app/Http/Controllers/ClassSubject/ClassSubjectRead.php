<?php

namespace App\Http\Controllers\ClassSubject;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class ClassSubjectRead extends Controller
{
    public function getClassSubjectByClassId(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,class_id',
        ]);

        $subjects = ClassSubject::where(
            'class_id',
            $request->class_id
        )
            ->orderBy('class_subject_id', 'asc')
            ->get();

        return response()->json([
            'message' => 'Class subjects fetched successfully',
            'subjects' => $subjects
        ], 200);
    }
}
