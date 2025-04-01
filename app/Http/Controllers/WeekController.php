<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WeekController extends Controller
{
    public function create(Request $request) : View
    {
        $type = $request->input('type');
        $nbWeeks = $request->input('nb-weeks');
        $nbFields = 5;
        $nbHours = 10;
        return match ($type) {
            'planning' => view('planning-weeks' , ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours]),
            'journal' => view('journal-weeks'),
            'diagram' => view('diagram'),
            default => view('index'),
        };
    }
}
