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

        <div class="week-space">
            <form action="/create" method="POST">
                @csrf



                @for($i = 1; $i < $nbWeeks + 1; $i++)
                    <table class="week-table">
                        <thead>
                        <tr>
                            <th colspan="4" class="week-title">Semaine {{$i}}</th>
                        </tr>
                        <tr>
                            <th>Tâche</th>
                            <th>Durée</th>
                            <th>Explications</th>
                            <th>Liens</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($j = 1; $j < $nbFields + 1; $j++)
                        <tr>
                            <td class="td-select">
                                <select name="task{{$i}}">
                                    @foreach($tasksToInsert as $task)
                                    <option value="option{{$i}}">{{$task['taskName']}}</option>
                                    @endforeach
                                </select></td>
                            <td class="td-select"><select name="time{{$i}}">
                                    @for($k = 0; $k < $nbHours + 1; $k++)
                                        <option value="{{$k}}">{{$k}}h</option>
                                    @endfor
                                </select></td>
                            <td><textarea type="text" name="desc{{$i}}"></textarea></td>
                            <td><textarea type="text" name="links{{$i}}"></textarea></td>
                        </tr>
                        @endfor
                        </tbody>
                    </table>
                @endfor
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </body>
</html>
