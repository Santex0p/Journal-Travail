<?php

use App\Http\Controllers\WeekController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\ProtectPostRoutes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\TaskController;




Route::middleware('auth')->group(function () {
    Route::post('/create', [TaskController::class, 'create'])->name('create.data');
    Route::post('/create-weeks', [WeekController::class, 'createdata'])->name('create.weeks');
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
});



Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'login'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//Route::fallback(function () {return redirect()->route('dashboard')->with('error', 'Page not found');});
