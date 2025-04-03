<?php

use App\Http\Controllers\WeekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\TaskController;

Route::get('/', [Controller::class, 'index'])->name('index');
Route::post('/create', [TaskController::class, 'create'])->name('create.data');
Route::post('/create-weeks', [WeekController::class, 'create'])->name('create.weeks');
Route::get('/login', [Controller::class, 'index'])->name('login.view');
Route::post('/auth', [AuthController::class, 'login'])->name('login');
Route::get('/dashboard', [Controller::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
