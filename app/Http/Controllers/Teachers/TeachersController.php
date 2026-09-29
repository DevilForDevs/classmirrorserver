<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Teacher;



class TeachersController extends Controller
{
    public function getTeachersList()
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {

            $teacher->resources = Resource::where(
                'owner_table',
                'teachers'
            )
                ->where(
                    'owner_row_id',
                    $teacher->teacher_id
                )
                ->get([
                    'resource_id',
                    'title',
                    'url'
                ]);
        }

        return response()->json([
            'teachers' => $teachers
        ]);
    }
}
