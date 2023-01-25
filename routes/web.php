<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VitrineController;
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

Route::get('/', [VitrineController::class, 'index'])->name('home');
Route::get('/projects', [VitrineController::class, 'index'])->name('projects');
Route::get('/project/{project}', [ProjectController::class, 'index'])->name('project');
