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

Route::middleware('auth:api')->get('/user', 'Api\Runner\AuthController@register');

Route::middleware('auth:api')->get('/v1/runner/register', 'Api\Runner\AuthController@register');

Route::group([
	'middleware'=>'auth:api',
    'namespace' => 'Api\Runner',
    'prefix' => 'v1/runner'

], function ($router) {
	
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::post('pickup-jobs', 'getPickupJobs@getPickupJobs');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

});