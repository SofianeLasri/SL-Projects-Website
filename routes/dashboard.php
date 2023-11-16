<?php

use App\Http\Controllers\Dashboard\Components\MediaUploadZoneController;
use App\Http\Controllers\Dashboard\MediaLibraryController;
use App\Http\Controllers\Dashboard\Projects\AddProjectController;
use App\Http\Controllers\RobotsTxtController;

Route::domain(config('app.domain.dashboard'))->name('dashboard.')->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('home');

        Route::name('media-library.')->prefix('media-library')->group(function () {
            Route::get('/', [MediaLibraryController::class, 'page'])->name('page');
            Route::get('/get-uploaded-files', [MediaLibraryController::class, 'getUploadedFiles'])->name('get-uploaded-files');
        });

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
                    Route::post('/find-icon', [MediaUploadZoneController::class, 'findIcon'])->name('find-icon');
                    Route::post('/upload-file', [MediaUploadZoneController::class, 'uploadFile'])->name('upload-file');
                });
            });
        });

        Route::name('projects.')->prefix('projects')->group(function () {
            Route::get('/add', [AddProjectController::class, 'index'])->name('add');
        });
    });
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
