@extends('layouts.app')

@section('title', 'Add Announcement')

@section('content')

<div class="card">

    ```
    <h1>Add Announcement</h1>

    <form method="POST" action="{{ route('announcements.store') }}">

        @csrf

        <div class="form-group">
            <label for="title">Title</label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                required>

            @error('title')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="announcement">Announcement</label>

            <textarea
                id="announcement"
                name="announcement"
                rows="8"
                required>{{ old('announcement') }}</textarea>

            @error('announcement')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="resource_id">Resource ID</label>

            <input
                type="number"
                id="resource_id"
                name="resource_id"
                value="{{ old('resource_id') }}"
                min="1"
                placeholder="Optional">

            @error('resource_id')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">
            Add Announcement
        </button>

    </form>
    ```

</div>

@endsection