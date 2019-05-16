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

Route::group([
//	'middleware'=>'auth:api',
    'namespace' => 'Api\Runner',
    'prefix' => 'v1/runner'

], function ($router) {
	
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    
    Route::post('pickup-jobs', 'PickupController@getPickupJobs');
    Route::post('delivery-jobs', 'PickupController@getDeliveryJobs');

    Route::post('customer/register', 'CustomerController@store');

    Route::post('order-details', 'PickupController@getOrderDetails');
    Route::post('last-order-details', 'PickupController@getLastOrderDetails');
    Route::post('cancel-request', 'PickupController@cancelRequest');

    Route::post('search-customer', 'CustomerController@searchCustomer');


    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

});
