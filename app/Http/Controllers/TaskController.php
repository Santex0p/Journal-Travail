<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
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
        }
        //dd($dataTasks);

        $tasks = [];
        $nbTasks = 25;
        $currentIndex = 1;
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
        for ($currentIndex; $currentIndex <= $nbTasks; $currentIndex++) // + 2 to avoid fields 0 and 1 which are reserved
        {
            $tasks[$currentIndex]= [
                'taskId' => null,
                'taskName' => null,
            ];

        }
        //dd($tasks);


        return view('project-data', ['tasks' => $tasks, 'data' => $data]);
    }
}
