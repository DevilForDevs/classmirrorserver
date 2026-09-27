<?php

use App\Http\Controllers\LecturesSchedule\LectureScheduleRead;
use App\Http\Controllers\LecturesTable\ReadController as LecturesTableReadController;
use App\Http\Controllers\LectureStatesTable\LectureStateWrite;
use App\Http\Controllers\SyllabusTable\ReadController;
use App\Http\Controllers\Teachers\TeachersController;
use Illuminate\Support\Facades\Route;

Route::get('/syllabus/sessions', [ReadController::class, 'getAcademicSessions']);

Route::get('/syllabus/by-session', [ReadController::class, 'getSyllabusBySession']);


Route::get('/lectures/topic', [LecturesTableReadController::class, 'getLecturesByTopicId']);

Route::get('/lectures/teacher', [LecturesTableReadController::class, 'getLecturesByTeacherId']);

Route::get('/lectures/status', [LecturesTableReadController::class, 'getLecturesByStatus']);

Route::get('/teachers', [TeachersController::class, 'getTeachersList']);


Route::get(
    '/lecture-states/lecture',
    [LecturesTableReadController::class, 'getLectureStateByLectureId']
);

Route::post(
    '/lecture-states',
    [LectureStateWrite::class, 'addLectureState']
);


Route::get(
    '/lecture-schedule',
    [LectureScheduleRead::class, 'getSchedule']
);
