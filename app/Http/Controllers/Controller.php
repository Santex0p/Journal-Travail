<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

class Controller
{
    public function index() : View
    {
        for ($i = 1; $i < 25 + 1; $i++)
        {
            $tasks[] = "task-$i";
        }
        return view('index', ['tasks' => $tasks]);
    }
}
