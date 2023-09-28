<?php

use App\Http\Controllers\Dashboard\FilemanagerController;
use App\Http\Controllers\Dashboard\Projects\AddProjectController;
use App\Http\Controllers\RobotsTxtController;
use App\View\Components\Dashboard\MediaUploadZoneFile;

Route::domain(config('app.domain.dashboard'))->name('dashboard.')->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('home');
        Route::get('/media-library', [FilemanagerController::class, 'index'])->name('media-library');

        // Requêtes AJAX
        Route::name('ajax.')->prefix('ajax')->group(function () {
            Route::get('/set-sidebar-state', function () {
                cookie()->queue('isDashboardSidebarOpened', request()->input('opened') === 'true' ? 'true' : 'false', 60 * 24 * 30); // 30 jours
            })->name('set-sidebar-state');

            // Propres à la création de projets
            Route::name('projects.')->prefix('projects')->group(function () {
                Route::post('/check-slug', [AddProjectController::class, 'checkSlug'])->name('check-slug');
                Route::post('/check-name', [AddProjectController::class, 'checkName'])->name('check-name');
            });

            // Composants
            Route::name('components.')->prefix('components')->group(function () {
                Route::name('media-upload-zone.')->prefix('media-upload-zone')->group(function () {
                    Route::get('/get-rendered-file-list-component', function () {
                        return (new MediaUploadZoneFile())->render();
                    })->name('get-rendered-file-list-component');
                });
            });
        });

        Route::name('projects.')->prefix('projects')->group(function () {
            Route::get('/add', [AddProjectController::class, 'index'])->name('add');
        });
    });
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
