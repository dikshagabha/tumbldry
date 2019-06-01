<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
    use Appnings\Payment\Facades\Payment;    

class PaymentController extends Controller
{
    public function pay(Request $request){
    	
      $parameters = [
      
        'tid' => '1233221223322',
        
        'order_id' => '1232212',
        
        'amount' => '1200.00',
        
      ];
      
      $order = Payment::prepare($parameters);
      return Payment::process($order);
    }
}
