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
	'middleware'=>'PreflightResponse',
    'namespace' => 'Api\Runner',
    'prefix' => 'v1/runner'

], function ($router) {
	
    Route::get('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('otp', 'AuthController@sendOtp');
    Route::post('verify-otp', 'AuthController@verifyotp');


    Route::get('services', 'OrderController@services');
    Route::get('laundary-addons', 'OrderController@laundaryAddons');
    Route::get('dryclean-addons', 'OrderController@dryCleanAddons');
    Route::get('service-price', 'OrderController@servicePrice');
    Route::get('service-items', 'OrderController@serviceItems');

    
    Route::get('pickup-jobs', 'PickupController@getPickupJobs');
    Route::get('delivery-jobs', 'PickupController@getDeliveryJobs');

    Route::get('get-jobs', 'PickupController@getJobs');

    Route::get('pickup-details', 'PickupController@getPickupDetails');
    
    //Pickup Status
    Route::get('pickup/cancel-request', 'PickupController@cancelRequest');
    Route::get('pickup/accept-request', 'PickupController@acceptRequest');
    Route::get('pickup/out-for-pickup', 'PickupController@outforpickupRequest');
    Route::get('pickup/recieved-pickup', 'PickupController@recievedrunnerpickupRequest');
    Route::get('pickup/delivered-pickup', 'PickupController@deliveredpickupRequest');

    Route::post('customer/register', 'CustomerController@store');

    Route::get('order-details', 'PickupController@getOrderDetails');
    Route::get('last-order-details', 'PickupController@getLastOrderDetails');
    
    Route::get('search-customer', 'CustomerController@searchCustomer');
    Route::get('send-payment-link/{id}', 'OrderController@sendLink');
    
    Route::get('order/create', 'OrderController@createOrder');
});

Route::group([
    'middleware'=>'PreflightResponse',
    'namespace' => 'Api\Customer',
    'prefix' => 'v1/customer'

], function ($router) {
    Route::get('otp', 'AuthController@sendOtp');
    Route::get('addresses', 'HomeController@getcustomeraddresses');
    Route::get('update', 'HomeController@update');
    Route::post('login', 'AuthController@login');

    Route::post('save-address', 'HomeController@saveAddress');
    Route::get('store-suggestions', 'PickupController@storeSuggestions');
    Route::post('create-pickup', 'PickupController@createPickup');
});