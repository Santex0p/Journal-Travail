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
    <body>
    <header>
        <h1 class="app-title">Planify</h1>
        <nav>
            <a href="/">Dashboard</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <!-- Info de usuario y botones -->
            <div class="content-user">
                <div class="info-user">
                    <p>Bienvenue {{ Auth::user()->name }}</p>
                    <p>Email: {{ Auth::user()->email }}</p>
                </div>
                <div class="buttons-content">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn-logout" type="submit">Logout</button>
                    </form>
                    <form action="/data" method="POST">
                        @csrf
                        <button class="btn-create-journal" type="submit">Créer un nouveau project</button>
                    </form>
                </div>
            </div>

            <!-- Tabla de journals -->
            <div class="journal-table">
                @if($projects != null)
                    <table>
                        <thead>
                        <tr>
                            <th>Mes Journals</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project['datModule'] }}</td>
                                <td>
                                    <form action="/data" method="POST">
                                        @csrf
                                        <input type="hidden" name="dataId" value="{{ $project['id'] }}">
                                        <button><img src="{{ asset('img/pencil.png') }}" alt="edit"></button>
                                    </form>
                                    <form action="/del-project" method="POST">
                                        @csrf
                                        <input type="hidden" name="dataId" value="{{ $project['id'] }}">
                                        <button><img src="{{ asset('img/trash.png') }}" alt="delete"></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucun projet pour l'instant</p>
                @endif
            </div>
        </div>
    </div>
    </body>
</html>
