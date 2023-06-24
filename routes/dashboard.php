<?php

Route::domain(config('app.domain.dashboard'))->group(function () {
    Route::group(['middleware' => ['secure']], function () {
        Route::view('/', 'websites.dashboard.home')->name('dashboard.home');
    });
});

