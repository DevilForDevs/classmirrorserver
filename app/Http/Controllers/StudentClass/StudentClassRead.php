<?php

namespace App\Http\Controllers\StudentClass;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;

class StudentClassRead extends Controller
{
    public function getAllClasses()
    {
        $classes = StudentClass::orderBy(
            'class_id',
            'desc'
        )->get();

        return response()->json([
            'message' => 'Classes fetched successfully',
            'classes' => $classes
        ], 200);
    }
}
