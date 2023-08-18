<?php

use App\Http\Controllers\Dashboard\FilemanagerController;
use App\Http\Controllers\Dashboard\Projects\AddProjectController;
use App\Http\Controllers\RobotsTxtController;

Route::domain(config('app.domain.dashboard'))->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('dashboard.home');
        Route::get('/media-library', [FilemanagerController::class, 'index'])->name('dashboard.media-library');

        // Requêtes AJAX
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('/set-sidebar-state', function () {
                cookie()->queue('isDashboardSidebarOpened', request()->input('opened') === 'true' ? 'true' : 'false', 60 * 24 * 30); // 30 jours
            })->name('dashboard.ajax.set-sidebar-state');

            // Propres à la création de projets
            Route::group(['prefix' => 'projects'], function () {
                Route::post('/check-slug', [AddProjectController::class, 'checkSlug'])->name('dashboard.ajax.projects.check-slug');
                Route::post('/check-name', [AddProjectController::class, 'checkName'])->name('dashboard.ajax.projects.check-name');
            });
        });

        Route::group(['prefix' => 'projects'], function () {
            Route::get('/add', [AddProjectController::class, 'index'])->name('dashboard.projects.add');
        });
    });
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
