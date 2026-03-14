<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniCRM — Вход</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { background: #fff; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-card h1 { font-size: 1.5rem; margin-bottom: 1.5rem; text-align: center; color: #1e293b; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; color: #374151; }
        .form-control { width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9rem; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .btn { width: 100%; padding: 0.625rem; border: none; border-radius: 0.375rem; font-size: 0.9rem; font-weight: 600; cursor: pointer; background: #3b82f6; color: #fff; }
        .btn:hover { background: #2563eb; }
        .error { color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem; }
        .checkbox-row { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>MiniCRM</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Электронная почта</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Запомнить меня</label>
            </div>

            <button type="submit" class="btn">Войти</button>
        </form>
    </div>
</body>
</html>
