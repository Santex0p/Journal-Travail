<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WeekController extends Controller
{
    public function create(Request $request) : View
    {


        $type = $request->input('type');
        $nbWeeks = $request->input('nb-weeks');
        $nbFields = 5;
        $nbHours = 10;


        /*$request->validate([
            'module' => 'required|string|max:255',
            'name' => 'required|string|max:255', // Ajustar según las restricciones de la base de datos
        ]);


        switch ($type) {
            case 'planning':
                DB::table('t_data')->insert([
                    'datModule' => $request->input('module'),
                    'datName' => $request->input('name'),
                    ]);
                break;
                case 'journal':
        }*/

        return match ($type) {
            'planning' => view('planning-weeks' , ['nbWeeks' => $nbWeeks, 'nbFields' => $nbFields, 'nbHours' => $nbHours]),
            'journal' => view('journal-weeks'),
            'diagram' => view('diagram'),
            default => view('index'),
        };
    }
}
