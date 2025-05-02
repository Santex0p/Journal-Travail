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
            <h1>LE PLANIFICATEUR 3000</h1>
                <nav class="">
                </nav>
        </header>
        <div class="content-user">
                <table class="user-info">
                    <tr>
                        <td>{{Auth::user()->name}}</td>
                        <td>{{Auth::user()->email}}</td>
                    </tr>
                </table>
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
                    <td>{{$project['datModule']}}</td>
                    <td>
                        <form action="/data" method="POST">
                        @csrf
                        {{--Data Id in hidden to have acces to data in the next page--}}
                        <input type="hidden" name="dataId" value="{{$project['id']}}">
                        <button><img src="{{asset('img/pencil.png')}}" alt="edit"></button>
                        </form>
                        <form action="/del-project" method="POST">
                            @csrf
                            <input type="hidden" name="dataId" value="{{$project['id']}}">
                            <button><img src="{{asset('img/trash.png')}}" alt="delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
                @else
                    <p>Aucun projet pour l'instant</p>
                @endif
            </table>
        </div>
    </body>
</html>
