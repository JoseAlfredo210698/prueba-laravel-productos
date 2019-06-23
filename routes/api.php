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


/**
 * 127.0.0.0:8000/api/v1/
 */
Route::prefix('v1')->group(function () {
    Route::get('/', function(){
        return 'Welcome to my API';
    });
    Route::post('/signup', 'UserController@signup');
    Route::post('/login', 'UserController@login');
});


    





