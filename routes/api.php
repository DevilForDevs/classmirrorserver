<?php

use App\Http\Controllers\AnnouncemenTable\AnnouncementRead;
use App\Http\Controllers\ClassSubject\ClassSubjectRead;
use App\Http\Controllers\LecturesSchedule\LectureScheduleRead;
use App\Http\Controllers\LecturesTable\LectureReadController;
use App\Http\Controllers\StudentClass\StudentClassRead;
use App\Http\Controllers\SyllabusTable\SyllabusReadController;
use Illuminate\Support\Facades\Route;


//acess class table
Route::get('/getAllClasses', [StudentClassRead::class, 'getAllClasses']);

//acess class_subject table
Route::get('/getClassSubjectByClassId', [ClassSubjectRead::class, 'getClassSubjectByClassId']);

//acess lectures table
Route::get('/getLecturesByClassId', [LectureReadController::class, 'getLecturesByClassId']);

Route::get('/getLecturesByClassSubject', [LectureReadController::class, 'getLecturesByClassSubject']);

Route::get('/getByTeacherAndClassSubjectId', [LectureReadController::class, 'getByTeacherAndClassSubjectId']);


//acess syllabus table

Route::get(
    '/syllabus/class',
    [SyllabusReadController::class, 'getByClassId']
);

Route::get(
    '/syllabus/class-subject',
    [SyllabusReadController::class, 'getByClassSubjectId']
);

Route::get(
    '/syllabus/paper',
    [SyllabusReadController::class, 'getByPaperId']
);

Route::get(
    '/syllabus/teacher-class',
    [SyllabusReadController::class, 'getByTeacherAndClassId']
);

Route::get(
    '/syllabus/class-semester',
    [SyllabusReadController::class, 'getByClassIdAndSemester']
);

//acess lecture scheduled table
Route::get(
    '/getSchedule',
    [LectureScheduleRead::class, 'getSchedule']
);

//acess annoucement table
Route::get(
    '/getAnnoucements',
    [AnnouncementRead::class, 'getAnnoucements']
);
