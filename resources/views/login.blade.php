<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Web-Journal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="">
        <header class="">
                <nav class="">
                </nav>
        </header>
        <div class="login-container">
            <div class="login-card">
                <h1 class="login-title">
                    Bienvenue au <span class="brand">Planify</span>
                </h1>
                <form method="POST" action="{{ route('auth') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" required autofocus>
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required>
                        @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
