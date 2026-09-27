<?php

namespace App\Http\Controllers\SyllabusTable;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;


class ReadController extends Controller
{
    public function getAcademicSessions()
    {
        $sessions = Syllabus::query()
            ->select('session')
            ->distinct()
            ->orderBy('session')
            ->pluck('session');

        return response()->json($sessions);
    }

    public function getSyllabusBySessionAndSemester(Request $request)
    {
        $session = $request->input('session');
        $semester = $request->input('semester');

        $syllabus = Syllabus::where('session', $session)
            ->where('semester', $semester)
            ->get();

        return response()->json($syllabus);
    }
}
