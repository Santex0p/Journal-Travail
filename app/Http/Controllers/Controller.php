<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use function PHPUnit\Framework\matches;

class Controller
{
    public function index() : View
    {
        return match (request()->route()->getName()) {
            '' => view('dashboard'),
            'login.view' => view('login'),
            default => view('dashboard'),
        };
    }
}
