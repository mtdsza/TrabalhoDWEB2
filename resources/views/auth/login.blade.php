<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OdontoSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
        }
        .login-logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card shadow-sm login-card">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logotipo OdontoSys" class="login-logo">
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mb-3 text-center">
                    Credenciais inválidas. Por favor, tente novamente.
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">Lembrar-me</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>