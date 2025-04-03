<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;



class Controller extends BaseController
{
    public function index() : View
    {
        if (Auth::check()) {
            return view('welcome-user');
        }
        return view('login');
    }
}
