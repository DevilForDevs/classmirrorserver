<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;



class TeachersController extends Controller
{
    public function getTeachersList()
    {
        $teachers = Teacher::all();

        return response()->json($teachers);
    }
}
