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
      'admin-pickup-request' => 'Admin\PickupController',
      'manage-vendor' => 'Admin\VendorController',
      'admin-manage-plans' => 'Admin\PlansController',
      'manage-supplies' => 'Admin\SuppliesController',
      'edit-coupons' => 'Admin\CouponController',
    ]);
    
   
    Route::post('/vendor/status/{id}', 'Admin\VendorController@status')->name('manage-vendor.status');

    Route::get('/billing/excel', 'Admin\BillingController@downloadExcel')->name('billing.downloadExcel');
    Route::get('/billing', 'Admin\BillingController@index')->name('billing.index');
    Route::post('/billing', 'Admin\BillingController@importBilling')->name('billing.importBilling');

    Route::post('set-providers-session', 'Admin\VendorController@setSessionProviders')->name('admin.postAddSessionProviders');
    Route::post('/store/status/{id}', 'Admin\StoreController@status')->name('manage-store.status');
    Route::post('/pickp/assign-store/{id}', 'HomeController@assignStore')->name('admin.assignStore');

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

 Route::resources([
      'admin-pickup-request' => 'Admin\PickupController'
    ]);
 Route::post('/admin-session-address', 'Admin\PickupController@setSessionAddresses')->name('admin.setSessionAddresses');

 
  Route::get('/payment/{id}', 'Store\PaymentController@pay')->name('order.pay');
 
  
     Route::post('/payment/response', 'Store\PaymentController@response')->name('pay');
    Route::post('/payment/cancel', 'Store\PaymentController@cancel')->name('pay');
    Route::get('/payment/success', 'PaymentController@success')->name('pay');
  

Route::prefix('store')->namespace('Store')->group(function () {


   Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', 'LoginController@getLogin')->name('store.login');
        Route::post('/login', 'LoginController@postLogin')->name('store.login');

        Route::get('/forget-password', 'LoginController@forgetPassword')->name('store.forget-password');
        Route::post('/forget-password', 'LoginController@postforgetPassword')->name('store.forget-password');

      });
 
  Route::group(['middleware' => ['web', 'checkPrefix']], function () {
      Route::get('/', function () {
          return redirect()->route('store.login');
      });

     
     Route::group(['middleware' => ['store']], function () {
        Route::get('/home', 'HomeController@index')->name('store.home');

        Route::get('/change-password', 'HomeController@changePassword')->name('store.change-password');
        Route::post('/change-password', 'HomeController@postchangePassword')->name('store.change-password');

        Route::get('/new-customers', 'HomeController@newCustomers')->name('store.newCustomers');
        Route::get('/new-orders', 'HomeController@newOrders')->name('store.newOrders');
        Route::get('/orders-compare', 'HomeController@ordersCompare')->name('store.ordersCompare');
        Route::get('/orders-events', 'HomeController@ordersEvents')->name('store.ordersEvents');

         Route::get('/edit-profile', 'HomeController@editProfile')->name('store.edit-profile');
        Route::put('/edit-profile', 'HomeController@posteditProfile')->name('store.edit-profile');


         Route::resources([
            'manage-runner' => 'RunnerController',
            'manage-customer' => 'CustomerController',
            // 'manage-vendor' => 'VendorController',
            'store-pickup-request' => 'PickupController',
            'manage-plans' => 'PlanController',
            ]);
           
         

          Route::get('order/payment/{id}', 'PaymentController@getPaymentMode')->name('store.paymentmodes');


          Route::get('order/send-payment-link', 'PaymentController@sendPaymentLink')->name('store.sendPaymentLink');
          
          Route::post('order/payment/', 'PaymentController@payment')->name('store.payment');
          
          Route::get('/plans-payment/{id}', 'PaymentController@getPlansPayment')->name('plans.payment');
          Route::post('/plans-payment/', 'PaymentController@plansPayment')->name('store.plans.payment');

          Route::get('logout', 'LoginController@logout')->name('logout');

          Route::get('order/print/{id}', 'OrderController@invoice')->name('store.printInvoice');
          Route::post('order/assignvendor/', 'OrderController@assignvendor')->name('store.assignVendor');

          Route::post('plans/get-plans/', 'PlanController@getPlans')->name('store.getPlans');

         

          Route::post('set-store-timezone', 'HomeController@setTimezone')->name('store.set-timezone');

          Route::get('get-customer-addresses', 'HomeController@getCustomerAddresses')->name('store.getCustomerAddresses');

          Route::get('get-order-items/{id}', 'OrderController@getItemsForm')->name('store.getItemsForm');

          Route::get('/orders/', 'OrderController@index')->name('store.create-order.index');
          Route::get('/orders/assign-deliver/{id}', 'OrderController@getDeliveryDetails')->name('store.assignDeliver');
          
          Route::post('set-address-session', 'CustomerController@setSessionAddress')->name('store.postAddSessionAddress');
          Route::post('set-addresses-session', 'CustomerController@setSessionAddresses')->name('store.addCustomerAddresses');

          Route::post('store-service-input', 'OrderController@setServiceInput')->name('store.service.input');
          
          Route::post('delete-addresses-session', 'CustomerController@deleteSessionAddresses')->name('store.deleteCustomerAddresses');

          Route::get('export/settlement', 'ReportsController@exportCustomer')->name('store.export-settlement');
          
          Route::get('/payment', 'PaymentController@pay')->name('store.getRate');
          
          Route::get('/create-order/{id}', 'OrderController@create')->name('store.create-order');
          Route::post('/create-order/{id?}', 'OrderController@store')->name('store.create-order');

          Route::post('/order-complete/{id}', 'OrderController@complete')->name('store.order.complete');

          Route::get('/view-order/{id}', 'OrderController@view')->name('store.getOrderDetails');


          Route::post('/order/get-grn', 'OrderController@getGrn')->name('store.getGrn');
          Route::post('/order/deliver-items', 'OrderController@itemsDeliver')->name('store.itemsDeliver');
          Route::get('/create-order', 'OrderController@createWithoutPickup')->name('store.orderWithoutPickup');
          

          Route::get('/input-rate-card', 'RateCardController@getRate')->name('store.getInputRate');

          Route::get('/rate-card', 'RateCardController@index')->name('store.getRate');
          Route::get('/services', 'RateCardController@getServices')->name('store.getServices');

          Route::get('/get-items', 'OrderController@getItems')->name('store.get-items');
          Route::post('/add-items-session', 'OrderController@addItemSession')->name('store.addItemSession');
          Route::post('/delete-items-session', 'OrderController@deleteItemSession')->name('store.deleteItemSession');
          Route::post('/quantity-items-session', 'OrderController@quantityItemSession')->name('store.quantityItemSession');
          Route::post('/discount-items-session', 'OrderController@discountItemSession')->name('store.discountItemSession');
          Route::post('/addon-items-session', 'OrderController@addonItemSession')->name('store.addonItemSession');
          Route::post('/files-items-session', 'OrderController@filesItemSession')->name('store.filesItemSession');

          Route::post('/weight-items-session', 'OrderController@weightItemSession')->name('store.weightItemSession');
          Route::post('/coupon', 'OrderController@couponItemSession')->name('store.couponItemSession');


          Route::post('/order/status/{id}', 'OrderController@status')->name('store.order.status');
          
          Route::post('/order/assigndelivery', 'OrderController@assignDelivery')->name('store.order.assign-delivery');
          Route::post('/order/mark-recieved/{id}', 'OrderController@markRecieved')->name('store.mark-recieved');

          Route::post('/find-customer', 'HomeController@findCustomer')->name('store.findCustomer');

          Route::post('/runner/status/{id}', 'RunnerController@status')->name('manage-runner.status');
          Route::post('/customer/status/{id}', 'CustomerController@status')->name('manage-customer.status');
          //Route::post('/vendor/status/{id}', 'VendorController@status')->name('manage-vendor.status');

          Route::post('/notifications/read-all', 'NotificationsController@markRead')->name('notifications.mark-read'); 

          Route::post('/runner/assign-runner', 'RunnerController@assignRunner')->name('store.assign-runner');

          Route::get('/reports/customer', 'ReportsController@customerReports')->name('store.customer-reports');
          Route::get('/reports/order', 'ReportsController@orderReports')->name('store.order-reports');
          Route::get('/reports/accounting/ledger', 'ReportsController@ledger')->name('store.ledger-reports');
          Route::get('/reports/accounting/settlement', 'ReportsController@settlement')->name('store.settlement-reports');
    });
  });
});


Route::get('/customer-details/{id?}', 'Store\HomeController@getcustomerdetails')->name('getcustomerdetails');
Route::get('/address-details/{id}', 'Store\HomeController@getaddressdetails')->name('getaddressdetails');

