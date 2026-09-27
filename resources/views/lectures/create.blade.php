@extends('layouts.app')

@section('title', 'Add Lecture')

@section('content')

<div class="card">


    <h1>Add Lecture</h1>

    <form method="POST" action="{{ route('lectures.store') }}">

        @csrf

        <div class="form-group">
            <label for="topic_id">Topic</label>

            <select id="topic_id" name="topic_id" required>
                <option value="">Select Topic</option>

                @foreach ($topics as $topic)
                <option
                    value="{{ $topic->topic_id }}"
                    {{ old('topic_id') == $topic->topic_id ? 'selected' : '' }}>
                    {{ $topic->topic }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="started_at">Started At</label>

            <input
                type="datetime-local"
                id="started_at"
                name="started_at"
                value="{{ old('started_at') }}">
        </div>

        <div class="form-group">
            <label for="ended_at">Ended At</label>

            <input
                type="datetime-local"
                id="ended_at"
                name="ended_at"
                value="{{ old('ended_at') }}">
        </div>

        <div class="form-group">
            <label for="teacher_id">Teacher</label>

            <select id="teacher_id" name="teacher_id" required>
                <option value="">Select Teacher</option>

                @foreach ($teachers as $teacher)
                <option
                    value="{{ $teacher->teacher_id }}"
                    {{ old('teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>

            <select id="status" name="status">

                <option value="">Select status</option>

                <option value="activity"
                    {{ old('status') == 'activity' ? 'selected' : '' }}>
                    Activity
                </option>

                <option value="scheduled"
                    {{ old('status') == 'scheduled' ? 'selected' : '' }}>
                    Scheduled
                </option>

                <option value="ongoing"
                    {{ old('status') == 'ongoing' ? 'selected' : '' }}>
                    Ongoing
                </option>

                <option value="complete"
                    {{ old('status') == 'complete' ? 'selected' : '' }}>
                    Complete
                </option>

                <option value="broken"
                    {{ old('status') == 'broken' ? 'selected' : '' }}>
                    Broken
                </option>

                <option value="cancelled"
                    {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>

            </select>

        </div>

        <div class="form-group">
            <label for="description">Description</label>

            <textarea
                id="description"
                name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">
            Add Lecture
        </button>

    </form>


</div>

@endsection