<?php

use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\SofianeLasri\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(config('app.domain.sofianelasri'))->name('sofianelasri.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('home');
    Route::get('/robots.txt', [RobotsTxtController::class, 'index']);
});
