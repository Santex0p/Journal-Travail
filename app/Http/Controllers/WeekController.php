<?php

namespace App\Http\Controllers;

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

        //dd($request->all());

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
        $dataId = DB::table('t_data')->insertGetId([
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
        for($i = 0; $i <= $nbWeeks; $i++)
        {
            $weeksId = DB::table('t_weeks')->insertGetId([
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
        //dd($input);

        //dd($rulesTasks);

        $validatedTasks = $request->validate($rulesTasks);
        //dd($validatedTasks);




        $tasksToInsert = [];
        $tasksToInsert[] = [
            'taskName' => $request->input('obligatory-task'),
            'taskDescription' => '',
            'idWeeks' => DB::table('t_weeks')->where('id', $weeksId)->value('id'),
            'idData' => DB::table('t_data')->where('id', $dataId)->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
            ];
        for ($i = 1; $i <= $nbTasks; $i++) {
            if (!empty($validatedTasks['task-' . $i])) {
                $tasksToInsert[] = [
                    'taskName' => $validatedTasks['task-' . $i],
                    'taskDescription' => '',
                    'idWeeks' => DB::table('t_weeks')->where('id', $weeksId)->value('id'),
                    'idData' => DB::table('t_data')->where('id', $dataId)->value('id'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($tasksToInsert)) {
            DB::table('t_tasks')->insert($tasksToInsert);
        }


        return match ($type) {
            'planning' => view('planning-weeks' , ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert]),
            'journal' => view('journal-weeks'),
            'diagram' => view('diagram'),
            default => view('index'),
        };
    }
}
