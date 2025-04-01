<?php

use App\Http\Controllers\WeekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', [Controller::class, 'index'])->name('index');
Route::post('/create', [WeekController::class, 'create'])->name('weeks.create');
