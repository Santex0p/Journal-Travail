<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(): View
    {
        $tasks = [];
        for ($i = 1; $i < 25 + 1; $i++)
        {
            $tasks[] = "task-$i";
        }
        return view('project-data', ['tasks' => $tasks]);
    }
}
