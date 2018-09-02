<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datatables', ['as' => 'datatables', 'uses' => 'UserController@index']);
Route::post('/datatables/data', ['as' => 'datatables.data', 'uses' => 'UserController@getData']);
Route::delete('/datatables/{id}', ['uses' => 'UserController@destroy']);
