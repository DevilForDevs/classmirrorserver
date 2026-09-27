@extends('layouts.app')

@section('title', 'Add Lecture Schedule')

@section('content')

<div class="card">

    ```
    <h1>Add Lecture Schedule</h1>

    <form method="POST" action="{{ route('lecture-schedule.store') }}">

        @csrf

        <div class="form-group">
            <label for="day">Day</label>

            <select id="day" name="day" required>
                <option value="">Select Day</option>

                <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>
                    Monday
                </option>

                <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>
                    Tuesday
                </option>

                <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>
                    Wednesday
                </option>

                <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>
                    Thursday
                </option>

                <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>
                    Friday
                </option>

                <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>
                    Saturday
                </option>
            </select>

            @error('day')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>

            <input
                type="time"
                id="start_time"
                name="start_time"
                value="{{ old('start_time') }}"
                required>

            @error('start_time')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="period">Period</label>

            <input
                type="number"
                id="period"
                name="period"
                value="{{ old('period') }}"
                min="1">

            @error('period')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="teacher_id">Teacher</label>

            <select id="teacher_id" name="teacher_id" required>

                <option value="">Select Teacher</option>

                @foreach($teachers as $teacher)
                <option
                    value="{{ $teacher->teacher_id }}"
                    {{ old('teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
                @endforeach

            </select>

            @error('teacher_id')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">
            Add Schedule
        </button>

    </form>
    ```

</div>

@endsection