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
            <h1 class="app-title">Planify</h1>
            <nav class="">
                <a href="/">Dashboard</a>
            </nav>
        </header>
        <div class="content">
            <form action="/weeks" method="POST">
                @csrf
            <table>
                <tr>
                    <td>Module - Nom Project:</td>
                    <td><input type="text" name="module" value="{{$data->datModule ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Prénom - Nom:</td>
                    <td><input type="text" name="name" value="{{$data->datName ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Classe:</td>
                    <td><input type="text" name="class" value="{{$data->datClass ?? ''}}"></td>
                </tr>
                <tr>
                    <td><p class="section-1">Lieu:</p></td>
                    <td><input type="text" name="location" class="section-1" value="{{$data->datPlace ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Date Début:</td>
                    <td><input type="date" name="start-date" value="{{$data->datStartDate ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Date Fin:</td>
                    <td><input type="date" name="end-date" value="{{$data->datEndDate ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Nombre de Semaines:</td>
                    <td><input type="text" name="nb-weeks" value="{{$data->datNbWeeks ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Nombre de Periodes/Semaine:</td>
                    <td><input type="text" name="nb-weeks-hours" value="{{$data->datNbHour ?? ''}}"></td>
                </tr>
                <tr>
                    <td>Nombre de 1/4Heure/Periode:</td>
                    <td><input type="text" name="nb-1/4-hours" value="{{$data->datNbPeriod ?? ''}}"></td>
                </tr>
                <tr>
                    <td colspan="2" class="task-title">Liste des taches</td>
                </tr>
                <tr>
                    <td>Tache Obligatoire:</td>
                    <td><input type="text" name="1" value="Absence - Imprevus" readonly></td>
                </tr>
                @foreach ($tasks as $index => $task)
                    <tr>
                        @if($index != 1) {{--First task is reserved--}}
                        <td>{{ $index }}</td>
                        <td><input type="text" name="{{$index}}" value="{{ $task['taskName'] ?? '' }}"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
                <input type="hidden" name="data" value="{{$data}}">
            <div class="week-actions-bottom">
                {{--<button type="submit" class="btn-view" name="type" value="diagram">Création diagramme</button>--}}
                <button type="submit" class="btn-view" name="type" value="planning">@if($planning) Voir Planning @else Creation Planning @endif </button>
                <button type="submit" class="btn-view" name="type" value="journal">@if($journal) Voir Journal @else Creation Journal @endif</button>
            </div>
            </form>
        </div>
    </body>
</html>
