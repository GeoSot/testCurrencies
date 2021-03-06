<?php

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

Route::as('currencies.')->group( function () {
    Route::get('', "MainController@index")->name('index');
    Route::post('calculate-exchange', "MainController@getExchange")->name('calculate');
});

