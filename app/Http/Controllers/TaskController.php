<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function define() :View
    {
        $nbTasks = 25;
        for ($i = 1; $i < $nbTasks + 1; $i++)
        {
            $tasks[] = "task-$i";
        }
        return view('index', ['tasks' => $tasks]);
    }
}
