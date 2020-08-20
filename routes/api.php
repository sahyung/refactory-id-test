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

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
    Route::get('users/generate/token', 'AuthController@getToken');

    // Tier BREAD (Browse, Read, Edit, Add, Delete)
    Route::get('tiers', 'TierController@browse');
    Route::get('tiers/{id}', 'TierController@read');
    Route::put('tiers/{id}', 'TierController@edit');
    Route::post('tiers', 'TierController@add');
    Route::delete('tiers/{id}', 'TierController@delete');
});

Route::group(['middleware' => 'checkToken'], function () {
    Route::post('transactions', 'TransactionController@store');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgot', 'AuthController@forgot');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});
