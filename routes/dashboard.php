<?php

Route::domain(config('app.domain.dashboard'))->group(function () {
    Route::group(['middleware' => ['web']], function () {
        Route::view('/', 'websites.dashboard.home')->name('dashboard.home');
    });
});

