<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])
    ->name('index');
Route::post('/settings/save', [\App\Http\Controllers\SettingsController::class, 'save'])
    ->name('settings.save');
Route::get('/settings/get', [\App\Http\Controllers\SettingsController::class, 'get'])
    ->name('settings.get');
Route::get('/caught', [\App\Http\Controllers\CatchController::class, 'caught'])
    ->name('caught');
Route::any('/catch/{anything}', [\App\Http\Controllers\CatchController::class, 'catch'])
    ->name('catch');
