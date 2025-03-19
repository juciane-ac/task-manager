<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectController;

Route::get('/', function () {
    return view('list-tasks');
})->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.home');

    Route::middleware(['role:admin|manager'])->group(function () {
        Route::resource('projects', ProjectController::class);
    });

    Route::middleware(['role:admin|manager|user'])->group(function () {
        Route::resource('tasks', TaskController::class);
    });

});

Auth::routes();


require __DIR__.'/auth.php';

