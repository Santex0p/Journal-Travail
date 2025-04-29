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
        //$projects = DataProject::where('idUser', auth()->id())->get()->toArray();

        if(Auth::check() && auth()->user()->projects())
        {
            $projects = auth()->user()->projects()->get()->toArray(); //Eloquent
            return view('dashboard', ['projects' => $projects ?? null]);
        }
        return view('login');
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
