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
use function PHPUnit\Framework\isNumeric;
use function PHPUnit\Framework\isString;

class WeekController extends Controller
{
    /**
     * Handles the creation of data and related entities such as weeks and tasks.
     *
     * This method validates the provided request data, inserts a new project into the `DataProject` table,
     * creates associated weeks in the `Weeks` table, and processes task data to insert into the `Tasks` table.
     * The final view rendered depends on the `type` specified in the request, which determines the mode of data presentation.
     *
     * @param Request $request The HTTP request instance containing input data for project, weeks, and tasks.
     *
     * @return View A view instance corresponding to the specified `type` in the request, displaying the created data and associated entities.
     */
    public function createdata(Request $request) : View
    {


        $type = $request->input('type');
        $nbWeeks = $request->input('nb-weeks') + 1;
        $nbFields = 5;
        $nbHours = 10;
        $data = request()->input('data');



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

        if ($data == null)
        {
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
            for ($i = 1; $i < $nbWeeks; $i++) {
                $weeksId[] = Weeks::query()->insertGetId([
                    'weeName' => 'Semain ' . $i,
                    'weeStartDate' => now(),
                    'weeEndDate' => now(),
                    'idData' => $dataId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $rulesTasks = [];
            $indexTask = 1; // Number of task to validate NOTE: 1 is the first task, no 0
            foreach ($request->input() as $key => $value) {
                if (!is_null($request->input($key)) && is_numeric($key)) {
                    $rulesTasks[$indexTask] = 'nullable|string|max:255';
                    $indexTask++;
                }
            }

            // To validate tasks
            $validatedTasks = $request->validate($rulesTasks);

            $tasksToInsert = [];
            for ($i = 1; $i < $indexTask; $i++) {
                if (!empty($validatedTasks[$i])) {
                    $tasksToInsert[] = [
                        'taskName' => $validatedTasks[$i],
                        'taskDescription' => '',
                        //'idWeeks' => $weeksId[($i - 1) % count($weeksId)],
                        'idData' => $dataId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($tasksToInsert)) {
                foreach ($tasksToInsert as $taskIndex => $task) {
                    $taskID = Tasks::query()->insertGetId($task);
                    $tasksToInsert[$taskIndex]['id'] = $taskID;

                }
            }
            return match ($type) {
                'planning' => view('planning-weeks' , ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert, 'dataId' => $dataId, 'weeksId' => $weeksId]),
                'journal' => view('journal-weeks',['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert]),
                'diagram' => view('diagram'),
                default => view('index'),
            };

        }
        // TODO: Fix array values in weekId
        $arrayData = json_decode($data, true);

        $tasksToInsert = Tasks::query()->get()->where('idData', $arrayData['id'])->toArray();
        $dataId = DataProject::query()->get()->where('id', $arrayData['id'])->first()->id;
        $weeksTableId = Weeks::where('idData', $dataId)->pluck('id')->values()->toArray();
        dd($weeksTableId);
        foreach ($weeksTableId as $key => $value)
        {
            $weeksId[] = $value['id'];
        }
        dd($weeksId);

        return match ($type) {
            'planning' => view('planning-weeks', ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert, 'dataId' => $dataId, 'weeksId' => $weeksId]),
            'journal' => view('journal-weeks'),
            'diagram' => view('diagram'),
            default => view('index'),
        };

    }

    /**
     * Handles the saving of weekly data into the database.
     *
     * This method processes the input data from the request and saves it
     * into the database based on the type specified in the request. The
     * type determines whether the data is saved in the `Journal` or `Planning` table.
     *
     * @param Request $request The HTTP request instance containing the input data.
     *
     * @return RedirectResponse A redirect response to the dashboard route with a success message.
     */
    public function saveData(Request $request) : RedirectResponse
    {
        $weeksData = $request->input('weeks');
        $dataId = $request->input('dataId');

        foreach ($weeksData as $nbWeek => $data)
        {
            foreach ($data['tasks'] as $taskIndex => $taskData)
            {
                switch ($request->input('type')) {
                    case 'journal':
                        Journal::query()->UpdateOrInsert([
                            'idTask' => $taskData['option'],
                            'idProject' => $dataId,
                            'idWeeks' => $nbWeek,
                            'taskIndex' => $taskData['task_index'],
                            ],
                            [
                            'jouHours' => $taskData['time'],
                            'jouDescription' => $taskData['desc'],
                            'jouLinks' => $taskData['links'],
                            'updated_at' => now(),
                        ]);
                        break;
                    case 'planning':
                        Planning::query()->UpdateOrInsert([
                            'idTask' => $taskData['option'],
                            'idProject' => $dataId,
                            'idWeeks' => $nbWeek,
                            'taskIndex' => $taskData['task_index']
                            ],
                            [
                            'plaHours' => $taskData['time'],
                            'plaDescription' => $taskData['desc'],
                            'plaLinks' => $taskData['links'],
                            'updated_at' => now(),
                        ]);
                        break;
                }
            }
        }



        return redirect()->route('dashboard')->with('success', 'Data saved');
    }
}
