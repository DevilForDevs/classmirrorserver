```blade
@extends('layouts.app')

@section('title', 'Add Miscellaneous Resource')

@section('content')

<style>
    .resource-card {
        max-width: 700px;
        margin: 30px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }

    .resource-card h1 {
        margin: 0 0 25px;
        font-size: 28px;
        color: #222;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 130px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #555;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.08);
    }

    .submit-button {
        width: 100%;
        padding: 13px 18px;
        border: none;
        border-radius: 8px;
        background: #222;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .submit-button:hover {
        background: #000;
    }

    .error {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
        background: #ffe8e8;
        color: #a00000;
        border: 1px solid #ffbcbc;
    }

    .error ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .success {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
        background: #e8f7ed;
        color: #176b35;
        border: 1px solid #a9dfba;
    }

    @media (max-width: 600px) {
        .resource-card {
            margin: 15px;
            padding: 20px;
        }

        .resource-card h1 {
            font-size: 24px;
        }
    }
</style>

<div class="resource-card">

    <h1>Add Miscellaneous Resource</h1>

    @if ($errors->any())
    <div class="error">

        <strong>Please fix the following errors:</strong>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
    @endif

    @if (session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
    @endif

    <form
        method="POST"
        action="{{ route('miscellaneous-resources') }}">

        @csrf

        <div class="form-group">

            <label for="title">
                Title
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                placeholder="Enter resource title"
                required>

        </div>


        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Enter a description (optional)">{{ old('description') }}</textarea>

        </div>


        <button
            type="submit"
            class="submit-button">
            Add Resource
        </button>

    </form>

</div>

@endsection
```