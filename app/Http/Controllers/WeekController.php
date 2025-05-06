<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use App\Models\Journal;
use App\Models\Planning;
use App\Models\Tasks;
use App\Models\Weeks;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Ramsey\Uuid\Rfc4122\Validator;
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

        // Create new project data
        if ($data == null)
        {
            $selectedTaskMapping = null;

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


            // Insert Weeks TODO: make the difference between planning and journal weeks
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

            $tasksToInsert = [];
            foreach ($this->validateTasks($request, false) as $taskIndex => $task) {
                    $tasksToInsert[] = [
                        'taskName' => trim($task),
                        'idData' => $dataId,
                        'taskCase' => $taskIndex,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
            }


            if (!empty($tasksToInsert)) {
                foreach ($tasksToInsert as $taskIndex => $task) {
                    $taskID = Tasks::query()->insertGetId($task);
                    $tasksToInsert[$taskIndex]['id'] = $taskID;

                }
            }

        }
        else
        {
        $arrayData = json_decode($data, true); // To decode data
        $dataId = DataProject::query()->get()->where('id', $arrayData['id'])->first()->id;
        $weeksId = Weeks::where('idData', $dataId)->pluck('id')->toArray();
        $journalData = Journal::query()->get()->where('idProject', $dataId)->toArray();
        $joinPlanningTask = Planning::whereHas('task', function ($query) use ($dataId) {$query->where('idData', $dataId);})->with('task')->get()->toArray(); // WhereHas used to have the idData of task table
        $joinJournalTask = Journal::whereHas('task', function ($query) use ($dataId) {$query->where('idData', $dataId);})->with('task')->get()->toArray();
        $selectedTaskMapping = [];
        $validated = $this->validateTasks($request, true);


        $toUpsert = [];
        foreach ($validated as $case => $taskName) {
            $taskName = trim($taskName);
            if($taskName != '')
            {
                $toUpsert[] = [
                    'idData' => $dataId,
                    'taskName' => $taskName,
                    'taskCase' => $case,
                ];
            }
        }

        // To Update Or Insert Tasks
        Tasks::upsert($toUpsert, ['idData', 'taskCase'],['taskName', 'updated_at']);

        // Array filter get value in trim and ignore null values, array keys got the id of array and array to convert in int the keys
        $submittedCases = array_map(
            'intval', array_keys(array_filter($validated, fn($name) => trim($name) !== ''))
        );

        // To delete all records where there are no tasks because submitted class have only valid tasks
        Tasks::where('idData', $dataId)->whereNotIn('taskCase', $submittedCases)->delete();


        // Fill data tasks according to type
        switch ($type) {
            case 'planning':
                foreach ($joinPlanningTask as $planning)
                {
                    $weekId = $planning['idWeeks']; // To indexing with id of week
                    $selectedTaskMapping[$weekId][$planning['taskIndex']] = $planning; // To Index with week and task index
                }
                break;
            case 'journal':
                foreach ($joinJournalTask as $journal)
                {
                    $weekId = $journal['idWeeks'];
                    $selectedTaskMapping[$weekId][$journal['taskIndex']] = $journal;
                }
                break;
        }

        $tasksToInsert = Tasks::query()->get()->where('idData', $arrayData['id'])->toArray(); // After upsert
        }


        return match ($type) {
            'planning' => view('planning-weeks', ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert, 'dataId' => $dataId, 'weeksId' => $weeksId, 'selectedTask' => $selectedTaskMapping]),
            'journal' => view('journal-weeks', ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours, 'tasksToInsert' => $tasksToInsert, 'dataId' => $dataId, 'weeksId' => $weeksId, 'selectedTask' => $selectedTaskMapping]),
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
        //dd(request()->input());
        $dataId = $request->input('dataId');
        //dd($dataId, $weeksData);

        foreach ($weeksData as $nbWeek => $data)
        {
            foreach ($data['tasks'] as $taskIndex => $taskData)
            {
                switch ($request->input('type')) {
                    case 'journal':
                        Journal::query()->UpdateOrInsert([
                            'idProject' => $dataId,
                            'idWeeks' => $nbWeek,
                            'taskIndex' => $taskData['task_index'],
                            ],
                            [
                            'idTask' => $taskData['option'],
                            'jouHours' => $taskData['time'],
                            'jouDescription' => $taskData['desc'],
                            'jouLinks' => $taskData['links'],
                            'updated_at' => now(),
                        ]);
                        break;
                    case 'planning':
                        Planning::query()->UpdateOrInsert([
                            'idProject' => $dataId,
                            'idWeeks' => $nbWeek,
                            'taskIndex' => $taskData['task_index']
                            ],
                            [
                            'idTask' => $taskData['option'],
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

    // To Validate incoming tasks from data
    private function validateTasks(Request $request, bool $withNull): array
    {
        $rulesTasks = [];
        foreach ($request->input() as $key => $value) {
            if ($withNull) {
                if (is_numeric($key)) {
                    $rulesTasks[$key] = 'nullable|string|max:255';
                }
            }
            else
            {
                if (!is_null($request->input($key)) && is_numeric($key)) {
                    $rulesTasks[$key] = 'nullable|string|max:255';
                }

            }
        }
        // To validate tasks
        return $validatedTasks = $request->validate($rulesTasks);
    }
}
