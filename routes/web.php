<?php

use App\Http\Controllers\AnnouncemenTable\AnnouncementWrite;
use App\Http\Controllers\LecturesSchedule\LecturesScheduleWrite;
use App\Http\Controllers\LecturesTable\WriteController;
use App\Http\Controllers\ResourceTable\ResourceWrite;
use App\Http\Controllers\SyllabusTable\WriteController as SyllabusTableWriteController;
use App\Http\Controllers\Users\AddController;
use App\Models\Syllabus;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('login');
})->name('login');


Route::post('/signin', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    return back()
        ->withErrors([
            'email' => 'Invalid email or password.',
        ])
        ->withInput();
})->name('signin');


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Syllabus
    |--------------------------------------------------------------------------
    */

    Route::get('/syllabus/create', function () {
        return view('syllabus.create');
    })->name('syllabus.create');

    Route::post('/syllabus', [SyllabusTableWriteController::class, 'addTopic'])->name('syllabus.store');


    /*
    |--------------------------------------------------------------------------
    | Lectures
    |--------------------------------------------------------------------------
    */

    Route::get('/lectures/create', function () {

        $teachers = Teacher::select('teacher_id', 'name')->get();

        $topics = Syllabus::select('topic_id', 'topic')->get();

        return view('lectures.create', compact('teachers', 'topics'));
    })->name('lectures.create');


    Route::post('/lectures', [WriteController::class, 'addLecture'])
        ->name('lectures.store');


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create');

    Route::post('/users', [AddController::class, 'addUser'])->name('users.store');


    /*
    |--------------------------------------------------------------------------
    | Add User Controller
    |--------------------------------------------------------------------------
    */

    Route::post('/addUser', [AddController::class, 'addUser'])
        ->name('users.add');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', function (Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginpage');
    })->name('logout');


    /*
|-------------------------------------------------------------------------- 
| Lecture Schedule
|-------------------------------------------------------------------------- 
*/

    Route::get('/lecture-schedule/create', function () {

        $teachers = Teacher::select('teacher_id', 'name')
            ->orderBy('name')
            ->get();

        return view('lecture_schedule.create', compact('teachers'));
    })->name('lecture-schedule.create');


    Route::post(
        '/lecture-schedule',
        [LecturesScheduleWrite::class, 'addSchedule']
    )->name('lecture-schedule.store');

    Route::get('/announcement/create', function () {
        return view('announcement.create');
    })->name('announcement.create');

    Route::post('/announcements', [AnnouncementWrite::class, 'addAnnouncement'])
        ->name('announcements.store');

    Route::post('/resource/upload', [ResourceWrite::class, 'upload'])
        ->name('resource.upload');

    Route::get('/resource/upload', function () {
        return view('resource.upload', [
            'ownerTable' => null,
            'ownerRowId' => null,
        ]);
    })->name('resource.upload.page');
});
