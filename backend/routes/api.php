<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api'])->group(function () {
    Route::post('/login', 'API\LoginController@login');
});

Route::middleware(['auth:myauth'])->group(function () {
    Route::get('/whoami', 'API\LoginController@whoami');

    Route::get('employee', 'API\EmployeeController@index');
    Route::post('employee', 'API\EmployeeController@store');
    Route::get('employee/{employee}', 'API\EmployeeController@show');
    Route::put('employee/{employee}', 'API\EmployeeController@update');
    Route::delete('employee/{employee}', 'API\EmployeeController@destroy');
    Route::get('employee/selector', 'API\EmployeeController@selector');
});