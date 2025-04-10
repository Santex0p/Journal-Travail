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
        for ($i = 1; $i < $nbTasks + 1; $i++)
        {
            $tasks[] = "task-$i";
        }
        return view('project-data', ['tasks' => $tasks]);
    }
}
