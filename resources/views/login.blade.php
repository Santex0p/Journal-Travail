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
        <div class="login">
            <form action="/auth" method="POST">
                @csrf
                <table>
                <tr>
                    <td>
                        <label for="email">Username</label>
                        <input type="text" name="email" id="email" />
                    </td>
                    <td>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </td>
                </tr>
                </table>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
</html>
