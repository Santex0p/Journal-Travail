<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use App\Models\Journal;
use App\Models\Planning;
use App\Models\Tasks;
use App\Models\Weeks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WeekController extends Controller
{
    public function createdata(Request $request) : View
    {


        $type = $request->input('type');
        $nbWeeks = $request->input('nb-weeks');
        $nbFields = 5;
        $nbHours = 10;
        $nbTasks = 0;

        do
        {
            $nbTasks++;
        }
        while(!empty($request->input('task-' . $nbTasks)));

        $validatedData = $request->validate([
            'module' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start-date' => 'required|date',
            'end-date' => 'required|date|after_or_equal:start-date',
            'nb-weeks' => 'required|integer|min:1|max:100',
            'nb-weeks-hours' => 'nullable|integer|min:1|max:100',
            'nb-1/4-hours' => 'nullable|integer|min:1|max:100',
        ]);

        // Insert data

        $dataId = DataProject::query()->insertGetId([
            'idUser' => auth()->id(), // fKey user
            'datModule' => $request->input('module'),
            'datName' => $request->input('name'),
            'datClass' => $request->input('class'),
            'datPlace' => $request->input('location'),
            'datStartDate' => $request->input('start-date'),
            'datEndDate' => $request->input('end-date'),
            'datNbWeeks' => $request->input('nb-weeks'),
            'datNbHour' => $request->input('nb-weeks-hours'),
            'datNbPeriod' => $request->input('nb-1/4-hours'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // Insert Weeks
        $weeksId = [];
        for($i = 0; $i < $nbWeeks; $i++)
        {
            $weeksId[] = Weeks::query()->insertGetId([
                'weeName' => 'Semain ' . $i,
                'weeStartDate' => now(),
                'weeEndDate' => now(),
                'idData' => $dataId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $input = [];
        $rulesTasks = [];
        for ($i = 0; $i <= $nbTasks; $i++) {
            if(!empty($request->input('task-' . $i))) {
                $rulesTasks['task-' . $i] = 'nullable|string|max:255';
                $input[] = $request->input('task-' . $i);
            }
        }

        $validatedTasks = $request->validate($rulesTasks);


        $tasksToInsert = [];
        for ($i = 1; $i < $nbTasks; $i++) {
            if (!empty($validatedTasks['task-' . $i])) {
                $tasksToInsert[] = [
                    'taskName' => $validatedTasks['task-' . $i],
                    'taskDescription' => '',
                    'idWeeks' => $weeksId[($i - 1) % count($weeksId)],
                    'idData' => $dataId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $tasksToInsertWithID = [];

        if (!empty($tasksToInsert)) {
            foreach ($tasksToInsert as $taskIndex => $task)
            {
                $taskID = Tasks::query()->insertGetId($task);
                //$task[$task]['taskID'] = $task;
                $tasksToInsert[$taskIndex]['taskID'] = $taskID;

            }
        }
        //dd($tasksToInsert);
        //dd($tasksToInsert);


        return match ($type) {
            'planning' => view('planning-weeks' , ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert]),
            'journal' => view('journal-weeks'),
            'diagram' => view('diagram'),
            default => view('index'),
        };
    }

    public function saveData(Request $request) : RedirectResponse
    {
        //dd($request->input());
        //$project = DataProject::query()->where('id', auth()->id());
        //foreach ($request->input() as $ => $value) {}
        $weeksData = $request->input('weeks');

        foreach ($weeksData as $nbWeek => $data)
        {
            foreach ($data['tasks'] as $taskIndex => $taskData)
            {
                switch ($request->input('type')) {
                    case 'journal':
                        Journal::query()->insert([
                            'jouHours' => $taskData['time'],
                            'jouDescription' => $taskData['desc'],
                            'jouLinks' => $taskData['links'],
                            'idTask' => $taskData['option'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        break;
                    case 'planning':
                        Planning::query()->insert([
                            'plaHours' => $taskData['time'],
                            'plaDescription' => $taskData['desc'],
                            'plaLinks' => $taskData['links'],
                            'idTask' => $taskData['option'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        break;
                }
            }
        }



        return redirect()->route('dashboard')->with('success', 'Data saved');
    }
}
