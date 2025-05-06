<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use App\Models\Journal;
use App\Models\Planning;
use App\Models\Tasks;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(Request $request): View
    {


        if ($request->input('dataId') !== null) {
            $dataId = $request->input('dataId');
            $data = DataProject::query()->get()->where('id', $dataId)->first();
            $dataTasks = Tasks::query()->get()->where('idData', $dataId)->select('taskName', 'id');
            $planningData = Planning::where('idProject', $dataId)->first();
            $journalData = Journal::where('idProject', $dataId)->first();
        }
        else
        {
            $data = null;
            $planningData = null;
            $journalData = null;
        }
        //dd($planningData);

        $tasks = [];
        $nbTasks = 25;
        $currentIndex = 1;
        // To get Tasks of project data
        if (isset($dataTasks)) {
            foreach ($dataTasks as $dataTask) {
                //dd($dataIndex);
                $tasks[$currentIndex] = [
                    'taskId' => $dataTask['id'],
                    'taskName' => $dataTask['taskName'],
                ];
                $currentIndex++;
            }
        }
        for ($currentIndex; $currentIndex <= $nbTasks; $currentIndex++)
        {
            $tasks[$currentIndex]= [
                'taskId' => null,
                'taskName' => null,
            ];

        }
        //dd($tasks);

        return view('project-data', ['tasks' => $tasks, 'data' => $data, 'planning' => $planningData ?? null, 'journal' => $journalData ?? null]);

    }
}
