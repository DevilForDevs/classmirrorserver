@extends('layouts.app')

@section('title', 'Add Syllabus')

@section('content')

<div class="card">

    ```
    <h1>Add Syllabus Topic</h1>

    <form method="POST" action="{{ route('syllabus.store') }}">

        @csrf

        <div class="form-group">
            <label for="session">Session</label>

            <input
                type="text"
                id="session"
                name="session"
                value="{{ old('session') }}"
                placeholder="e.g. 2024-2028"
                pattern="[0-9]{4}-[0-9]{4}"
                title="Enter session in the format YYYY-YYYY, e.g. 2024-2028"
                required>

            @error('session')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>

            <input
                type="number"
                id="semester"
                name="semester"
                value="{{ old('semester') }}"
                min="1"
                max="8"
                placeholder="e.g. 1"
                required>

            @error('semester')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="topic">Topic</label>

            <input
                type="text"
                id="topic"
                name="topic"
                value="{{ old('topic') }}"
                required>

            @error('topic')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="total_lectures">Total Lectures</label>

            <input
                type="number"
                id="total_lectures"
                name="total_lectures"
                value="{{ old('total_lectures', 0) }}"
                min="0">

            @error('total_lectures')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="author">Author</label>

            <input
                type="text"
                id="author"
                name="author"
                value="{{ old('author') }}">

            @error('author')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>

            <textarea
                id="description"
                name="description">{{ old('description') }}</textarea>

            @error('description')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">
            Add Topic
        </button>

    </form>
    ```

</div>

@endsection