<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tasks/filter', [HomeController::class, 'filterTasks'])->name('tasks.filter');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.home');

    Route::middleware(['role:admin|manager'])->group(function () {
        Route::resource('projects', ProjectController::class);
    });

    Route::middleware(['role:admin|manager|user'])->group(function () {
        Route::resource('tasks', TaskController::class);
        Route::post('/task/{task}/change-situation', [TaskController::class, 'changeSituation'])->name('task.ChangeSituation');
    });

});

Auth::routes();


require __DIR__.'/auth.php';

