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
        <div class="content">
            <form action="/create" method="POST">
                @csrf
                <table>
                    <tr>
                        <td>{{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td>{{Auth::user()->email}}</td>
                    </tr>
                </table>
            </form>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
            <form action="/create" method="POST">
                @csrf
            <table>
                <thead>
                <tr>
                    <th>Creation<th>
                    <th>Mes Journals</th>
                </tr>
                </thead>
                <tr>
                    <td><button type="submit">Créer un nouveau project</button></td>
                </tr>
            </table>
            </form>
        </div>
    </body>
</html>
