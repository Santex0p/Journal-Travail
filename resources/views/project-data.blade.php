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
            <form action="/create-weeks" method="POST">
                @csrf
            <table>
                <tr>
                    <td>Module:</td>
                    <td><input type="text" name="module"></td>
                </tr>
                <tr>
                    <td>Prénom - Nom:</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>Classe:</td>
                    <td><input type="text" name="class"></td>
                </tr>
                <tr>
                    <td><p class="section-1">Lieu:</p></td>
                    <td><input type="text" name="location" class="section-1"></td>
                </tr>
                <tr>
                    <td>Date Début:</td>
                    <td><input type="date" name="start-date"></td>
                </tr>
                <tr>
                    <td>Date Fin:</td>
                    <td><input type="date" name="end-date"></td>
                </tr>
                <tr>
                    <td>Nombre de Semaines:</td>
                    <td><input type="text" name="nb-weeks"></td>
                </tr>
                <tr>
                    <td>Nombre de Periodes/Semaine:</td>
                    <td><input type="text" name="nb-weeks-hours"></td>
                </tr>
                <tr>
                    <td>Nombre de 1/4Heure/Periode:</td>
                    <td><input type="text" name="nb-1/4-hours"></td>
                </tr>
                <tr>
                    <td colspan="2" class="task-title">Liste des taches</td>
                </tr>
                <tr>
                    <td>Tache Obligatoire:</td>
                    <td><input type="text" value="Absence - Imprevus" readonly></td>
                </tr>
                @foreach ($tasks as $index => $task)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><input type="text" name="{{ $task }}"></td>
                    </tr>
                @endforeach
            </table>
            <div class="buttons-form">
                <button type="submit" class="btn btn-creation-diagram" name="type" value="diagram">Création diagramme</button>
                <button type="submit" class="btn btn-creation-diagram" name="type" value="planning">Création Planning</button>
                <button type="submit" class="btn btn-creation-diagram" name="type" value="journal">Création Journal de travail</button>
            </div>
            </form>
        </div>
    </body>
</html>
