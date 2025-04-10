<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(): View
    {
        $tasks = [];
        $nbTasks = 25;
        for ($i = 2; $i < $nbTasks + 2; $i++) // + 2 to avoid fields 0 and 1 which are reserved
        {
            $tasks[] = "task-$i";
        }
        return view('project-data', ['tasks' => $tasks]);
    }
}
