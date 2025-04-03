<?php

use App\Http\Controllers\WeekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\AuthController;

Route::get('/', [Controller::class, 'index'])->name('index');
Route::post('/auth', [AuthController::class, 'authenticate'])->name('auth');
Route::get('/login', [Controller::class, 'index'])->name('login.view');
Route::post('/create', [WeekController::class, 'create'])->name('weeks.create');
Route::get('/welcome-user', function () {return view('welcome-user');})->middleware('auth.custom')->name('welcome-user');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
