<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('subscribe', 'PageController@subscribe');

Route::group([
    'middleware' => 'protect.api'
], function () {
    //List vacancies
    Route::get('vacancies', 'VacanciesController@index');
    //List Single vacancy
    Route::get('vacancy/{id}', 'VacanciesController@show');
    //Create new vacancy
    Route::post('vacancy', 'VacanciesController@store');
    //Update vacancy
    Route::put('vacancy', 'VacanciesController@store');
    //Delete vacancy
    Route::delete('vacancy/{id}', 'VacanciesController@destroy');
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

