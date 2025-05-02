<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class DataController extends Controller
{
    public function delete(Request $request) : RedirectResponse
    {
        DataProject::destroy(request('dataId'));

        return redirect('/');
    }
}
