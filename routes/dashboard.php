<?php

use App\Http\Controllers\RobotsTxtController;

Route::domain(config('app.domain.dashboard'))->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('dashboard.home');

        Route::group(['prefix' => 'ajax'], function () {
            Route::get('/set-sidebar-state', function () {
                cookie()->queue('desktopOpenedSidebar', request()->input('opened') === 'true' ? 'true' : 'false', 60 * 24 * 30); // 30 jours
            })->name('ajax.set-sidebar-state');
        });
    });
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
