<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\VitrineController;

Route::domain(config('app.domain.showcase'))->name('showcase.')->group(function () {
    Route::get('/', [VitrineController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/project/{project}', [ProjectController::class, 'index'])->name('project');
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
