<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Web-Journal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
<header class="">
    <nav class="">
    </nav>
</header>

<div class="week-space">
    <form action="/save-weeks" method="POST">
        @csrf
        @php $input = 1 @endphp
        @foreach($weeksId as $weekId)
            <table class="week-table">
                <thead>
                <tr>
                    <th colspan="4" class="week-title">Semaine {{$input++}}</th>{{--To number the weeks--}}
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
                    {{--WeekId and nb of id Task ($j) to locate the selected Case--}}
                    @php $currentSelected = $selectedTask[$weekId][$j] ?? null; @endphp
                    <tr>
                        <td class="td-select">
                            <select name="weeks[{{$weekId}}][tasks][{{$j}}][option]">
                                @foreach($tasksToInsert as $key => $task)
                                    <option
                                        value="{{$task['id']}}"{{$currentSelected && $task['id'] == $currentSelected['idTask'] ? 'selected' : '' }}> {{$task['taskName']}}</option>
                                @endforeach
                            </select></td>
                        <td class="td-select"><select name="weeks[{{$weekId}}][tasks][{{$j}}][time]">
                                @for($k = 0; $k < $nbHours + 1; $k++)
                                    <option name="{{$k}}" value="{{$k}}" {{$currentSelected && $currentSelected['plaHours'] == $k ? 'selected' : '' }}>{{$k}}h</option>
                                @endfor
                            </select></td>
                        <td><textarea type="text"
                                      name="weeks[{{$weekId}}][tasks][{{$j}}][desc]">{{$currentSelected['plaDescription'] ?? ''}}</textarea>
                        </td>
                        <td><textarea type="text"
                                      name="weeks[{{$weekId}}][tasks][{{$j}}][links]">{{$currentSelected['plaLinks'] ?? ''}}</textarea>
                        </td>
                    </tr>
                    <input type="hidden" name="weeks[{{ $weekId }}][tasks][{{ $j }}][task_index]" value="{{ $j }}">
                @endfor
                </tbody>
            </table>
        @endforeach
        <input type="hidden" name="dataId" value="{{$dataId}}">
        <button type="submit" name="type" value="planning">Sauvegarder</button>
    </form>
    <form action="/data" method="POST">
        @csrf
        <table>
            <tr>
                <td>
                    <input type="hidden" name="dataId" value="{{$dataId}}">
                    <button type="submit">Voir Data</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
