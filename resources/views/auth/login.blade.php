<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 360px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 24px;
            box-sizing: border-box;
        }

        .field {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: 0;
            border-radius: 4px;
            background: #111;
            color: #fff;
            cursor: pointer;
        }

        .error {
            color: #b00020;
            font-size: 14px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
<div class="card">
    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        @if ($errors->any())
            <div class="error">Неверный логин или пароль.</div>
        @endif

        <div class="field">
            <label for="login">Логин</label>
            <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus>
        </div>

        <div class="field">
            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>
        </div>

        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>
