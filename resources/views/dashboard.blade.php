@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="card">

    <h1>Dashboard</h1>

    <p>Welcome to the admin dashboard.</p>

    <div class="nav">
        <a href="{{ route('syllabus.create') }}">
            Add Syllabus
        </a>

        <a href="{{ route('lectures.create') }}">
            Add Lecture
        </a>

        <a href="{{ route('users.create') }}">
            Add User
        </a>

        <a href="{{ route('announcement.create') }}">
            Add Announcement
        </a>

        <a href="{{ route('lecture-schedule.create') }}">
            Add Lecture Schedule
        </a>

        <a href="{{ route('resource.upload') }}">
            Upload Resource
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                Logout
            </button>
        </form>



    </div>

</div>



@endsection