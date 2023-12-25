<?php

use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\Showcase\ProjectController;
use App\Http\Controllers\Showcase\ProjectsController;
use App\Http\Controllers\Showcase\StorageController;
use App\Http\Controllers\Showcase\VitrineController;

Route::domain(config('app.domain.showcase'))->name('showcase.')->group(function () {
    Route::get('/', [VitrineController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/project/{project}', [ProjectController::class, 'index'])->name('project');
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);

    Route::get('/storage/{path}', [StorageController::class, 'index'])->where('path', '.*')->name('storage')->withoutMiddleware(['web', 'auth']);
});
