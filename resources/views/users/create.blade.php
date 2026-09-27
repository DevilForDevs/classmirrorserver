@extends('layouts.app')

@section('title', 'Add User')

@section('content')

<div class="card">

    <h1>Add User</h1>

    <form method="POST" action="{{ route('users.store') }}">

        @csrf

        <div class="form-group">
            <label for="name">Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                maxlength="255"
                required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required>
        </div>

        <button type="submit">
            Add User
        </button>


        @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
        @endif

    </form>

</div>

@endsection