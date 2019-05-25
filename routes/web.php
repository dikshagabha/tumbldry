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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::prefix('admin')->group(function () {
  // Auth Routes
  Auth::routes(['register' => false]);
  Route::get('/', function () {
      return redirect()->route('login');
  });
  Route::post('/admin-login', 'Auth\LoginController@adminLogin')->name('admin.login');
  
  Route::group(['middleware' => ['admin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    // Edit Profile Routes
    Route::get('/edit-profile', 'HomeController@editProfile')->name('store.editProfile');
    Route::post('/edit-profile', 'HomeController@postEditProfile')->name('store.postEditProfile');

    Route::resources([
      'manage-frenchise' => 'Admin\FranchiseController',
      'manage-store' => 'Admin\StoreController',
      'manage-service' => 'Admin\ServiceController',
      'pickup-request' => 'Admin\PickupController',
      'manage-vendor' => 'Admin\VendorController',
    ]);
    
    Route::post('/vendor/status/{id}', 'Admin\VendorController@status')->name('manage-vendor.status');

      Route::post('set-providers-session', 'Admin\VendorController@setSessionProviders')->name('admin.postAddSessionProviders');
    Route::post('/store/status/{id}', 'Admin\StoreController@status')->name('manage-store.status');

    Route::post('/add-store/{id}', 'Admin\StoreController@saveSession')->name('admin.store.add');
    // Address Routes
    Route::get('/address', 'HomeController@addAddress')->name('admin.addAddress');
    Route::post('/address', 'HomeController@postAddAddress')->name('admin.postAddAddress');
    Route::get('/edit-address', 'HomeController@editAddress')->name('admin.editAddress');
    Route::post('/edit-address', 'HomeController@postEditAddress')->name('admin.postEditAddress');

    Route::get('/pin-details', 'HomeController@getPinDetails')->name('getPinDetails');

    Route::post('set-admin-timezone', 'HomeController@setTimezone')->name('admin.set-timezone');

    // Rate Cards
    Route::get('/rate-card', 'Admin\RateCardController@getRateCard')->name('admin.getRateCard');
    Route::get('/rate-card-form', 'Admin\RateCardController@getRateCardForm')->name('admin.getRateCardForm');
    Route::post('/rate-card-form', 'Admin\RateCardController@postRateCardForm')->name('admin.postRateCardForm');
    
    Route::get('/excel-download', 'Admin\RateCardController@getBlankExcel')->name('admin.getBlankExcel');

    Route::get('/services', 'HomeController@getServices')->name('admin.getServices');
    Route::post('/services', 'HomeController@getRate')->name('admin.getRate');
    
    Route::post('/find-customer', 'Admin\PickupController@findCustomer')->name('admin.findCustomer');
    Route::post('/find-user', 'HomeController@findUser')->name('admin.findUser');
    
    Route::post('set-address-session', 'CustomerController@setSessionAddress')->name('store.postAddSessionAddress');
      
    Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');

  });
});


Route::prefix('store')->namespace('Store')->group(function () {

   Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', 'LoginController@getLogin')->name('store.login');
        Route::post('/login', 'LoginController@postLogin')->name('store.login');

      });

  Route::group(['middleware' => ['web', 'checkPrefix']], function () {
      Route::get('/', function () {
          return redirect()->route('store.login');
      });

     
     Route::group(['middleware' => ['store']], function () {
         Route::get('/home', 'HomeController@index')->name('store.home');

         Route::resources([
            'manage-runner' => 'RunnerController',
            'manage-customer' => 'CustomerController',
            // 'manage-vendor' => 'VendorController',
            'store-pickup-request' => 'PickupController',
          ]);
      });
      
      Route::get('logout', 'LoginController@logout')->name('logout');

      Route::post('set-store-timezone', 'HomeController@setTimezone')->name('store.set-timezone');

      Route::get('/orders/', 'OrderController@index')->name('store.create-order.index');
      
      Route::post('set-address-session', 'CustomerController@setSessionAddress')->name('store.postAddSessionAddress');
      Route::post('set-addresses-session', 'CustomerController@setSessionAddresses')->name('store.addCustomerAddresses');
      Route::post('delete-addresses-session', 'CustomerController@deleteSessionAddresses')->name('store.deleteCustomerAddresses');
      
      
      Route::get('/create-order/{id}', 'OrderController@create')->name('store.create-order');
      Route::post('/create-order/{id?}', 'OrderController@store')->name('store.create-order');

      Route::get('/view-order/{id}', 'OrderController@view')->name('store.getOrderDetails');

      Route::post('/order/get-grn', 'OrderController@getGrn')->name('store.getGrn');
      Route::get('/create-order', 'OrderController@createWithoutPickup')->name('store.orderWithoutPickup');

      
      Route::get('/get-items', 'OrderController@getItems')->name('store.get-items');
      Route::post('/add-items-session', 'OrderController@addItemSession')->name('store.addItemSession');
      Route::post('/delete-items-session', 'OrderController@deleteItemSession')->name('store.deleteItemSession');
      Route::post('/quantity-items-session', 'OrderController@quantityItemSession')->name('store.quantityItemSession');
      Route::post('/discount-items-session', 'OrderController@discountItemSession')->name('store.discountItemSession');
      Route::post('/addon-items-session', 'OrderController@addonItemSession')->name('store.addonItemSession');
      Route::post('/coupon', 'OrderController@couponItemSession')->name('store.couponItemSession');

      Route::post('/order/status/{id}', 'OrderController@status')->name('store.order.status');
      Route::post('/order/assigndelivery/{id}', 'OrderController@assignDelivery')->name('store.order.assign-delivery');

      Route::post('/find-customer', 'HomeController@findCustomer')->name('store.findCustomer');

      Route::post('/runner/status/{id}', 'RunnerController@status')->name('manage-runner.status');
      Route::post('/customer/status/{id}', 'CustomerController@status')->name('manage-customer.status');
      //Route::post('/vendor/status/{id}', 'VendorController@status')->name('manage-vendor.status');

      Route::post('/notifications/read-all', 'NotificationsController@markRead')->name('notifications.mark-read'); 

      Route::post('/runner/assign-runner', 'RunnerController@assignRunner')->name('store.assign-runner');

  });
});


Route::get('/customer-details/{id?}', 'Store\HomeController@getcustomerdetails')->name('getcustomerdetails');
Route::get('/address-details/{id}', 'Store\HomeController@getaddressdetails')->name('getaddressdetails');