<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\VitrineController;

Route::domain(config('app.domain.showcase'))->group(function () {
    Route::get('/', [VitrineController::class, 'index'])->name('showcase.home');
    Route::get('/projects', [ProjectsController::class, 'index'])->name('showcase.projects');
    Route::get('/project/{project}', [ProjectController::class, 'index'])->name('showcase.project');
});

