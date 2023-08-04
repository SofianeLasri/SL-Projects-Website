<?php

use App\Http\Controllers\RobotsTxtController;

Route::domain(config('app.domain.dashboard'))->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('dashboard.home');
    });
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
