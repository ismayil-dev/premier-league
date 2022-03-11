<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\StandingController;
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

Route::get('/', [AppController::class, 'index'])->name('index');

Route::controller(MatchController::class)
    ->prefix('matches')
    ->as('matches.')
    ->group(function () {
        Route::post('/simulate-week/{week}', 'simulateWeek')->name('simulate_week');
        Route::post('/simulate-all', 'simulateAll')->name('simulate_all');
        Route::post('/fetch-all', 'fetchMatches')->name('fetch_all');
        Route::post('/reset', 'reset')->name('reset');
    });

Route::controller(StandingController::class)
    ->prefix('standings')
    ->as('standings.')
    ->group(function () {
        Route::post('/fetch', 'fetch')->name('fetch');
        Route::post('/predictions', 'fetchPredictions')->name('fetch_predictions');
    });
