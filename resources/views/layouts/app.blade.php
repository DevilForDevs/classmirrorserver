<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            min-height: 60px;
            background: #222;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .navbar h2 {
            margin: 0;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .nav {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav a {
            padding: 10px 15px;
            background: white;
            color: #222;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .nav a:hover {
            background: #ddd;
        }

        .nav form {
            margin: 0;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            padding: 10px 18px;
            background: #222;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #444;
        }


        /* =========================
           Tablet
           ========================= */

        @media (max-width: 768px) {

            .navbar {
                padding: 0 20px;
            }

            .container {
                margin: 20px auto;
                padding: 0 15px;
            }

            .nav {
                gap: 8px;
            }

            .nav a,
            .nav button {
                padding: 10px 14px;
            }

            .card {
                padding: 20px;
            }
        }


        /* =========================
           Mobile
           ========================= */

        @media (max-width: 480px) {

            .navbar {
                min-height: 55px;
                padding: 0 15px;
            }

            .navbar h2 {
                font-size: 20px;
            }

            .container {
                margin: 15px auto;
                padding: 0 10px;
            }

            .nav {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .nav a {
                width: 100%;
                text-align: center;
                padding: 12px;
            }

            .nav form {
                width: 100%;
            }

            .nav button {
                width: 100%;
                padding: 12px;
            }

            .card {
                padding: 18px;
                border-radius: 6px;
            }

            .card h1 {
                font-size: 24px;
            }

            input,
            textarea,
            select {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Admin Panel</h2>
    </div>

    <div class="container">

        <div class="nav">

            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('syllabus.create') }}">
                Add Syllabus
            </a>

            <a href="{{ route('lectures.create') }}">
                Add Lecture
            </a>

            <a href="{{ route('users.create') }}">
                Add User
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit">
                    Logout
                </button>
            </form>

        </div>

        @yield('content')

    </div>

</body>

</html>