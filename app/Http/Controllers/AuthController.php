<?php

namespace App\Http\Controllers;

use App\Models\DataProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function index(Request $request): View | RedirectResponse
    {
        $projects = DataProject::query()->where('id', auth()->id())->get();

        if($request->route()->getName() == 'index')
        {
            return redirect()->route('dashboard');
        }

        if(Auth::check())
        {
            return view('dashboard');
        }
        return view('login', ['projects', $projects]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('login');
    }
}
