<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            width: 350px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #222;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #444;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h2>Login</h2>

        @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('signin') }}">

            @csrf

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required>

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                required>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>