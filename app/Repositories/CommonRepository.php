<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

use App\Model\Token;
use App\User;
use App\Model\Address;
use App\Model\Order;
use App\Model\Coupon;
use App\Model\Service;
use Carbon\Carbon;
use textlocal;
/**
 * Class CommonRepository.
 */
class CommonRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }


    public static function sendNotificationToDevice($data)
    {
        $headers = [
            'Authorization: key=AIzaSyDNx0p6DXyFGZf5_9yhZNNnc1Em7hF48IM',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        foreach ($data as $data) {
            $data['message'] = ucwords($data['message']);
            $msg = [
                'body' => $data['message'],
                'data' => $data['data'],
                'title' => $data['title'],
                'icon' => 'myicon',
                'sound' => 'mySound'
            ];

            if (!is_array($data['token'])) {
                $data['token'] = [$data['token']];
            }

            $device_tokens = array_chunk($data['token'], 1000);
            foreach ($device_tokens as $device_token) {
                $fields = [
                    'registration_ids' => $device_token,
                    'notification' => $msg,
                    'data' => array_merge($data['data'], ['action' => 'OPEN_ACTIVITY_1'])
                ];
                // echo "<pre>"; print_r($fields); die('fff');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
            }
        }
        curl_close($ch);
    }

    public static function random_str($length=8, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
	}

    public static function getManageToken($token, $user_id): Token
    {
        return $token_get = Token::updateOrCreate(['user_id' => $user_id], ['token' => $token]);
    }

    public static function sendmessage($user, $message)
    {


           // $apiKey = urlencode('22bWsKcL+Yg-854jWZTrDkqQq0ceqh1iLESIqNirQd');
    
           //  // Message details
           //  $numbers = array($user);
           //  $sender = urlencode('TXTLCL');
           //  $message = rawurlencode($message);
         
           //  $numbers = implode(',', $numbers);
         
           //  // Prepare data for POST request
           //  $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
           //  // Send the POST request with cURL
           //  $ch = curl_init('https://api.textlocal.in/send/');
           //  curl_setopt($ch, CURLOPT_POST, true);
           //  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
           //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           //  $response = curl_exec($ch);
           //  curl_close($ch);
            
            // Process your response here
            //echo $response;

          //$sms = new Textlocal();
        //$response = $sms->send($message, $user);
        
        //dd('kasldll');
        $message  = urlencode($message);
        $url = 'https://push.sanketik.net//api/push?accesskey=jzzUlHL4NqhWs6VHzmUkGkYTaQKD7T&to='.$user.'&text='.$message.'&from=TBLDRY';

        //$url = str_replace(' ', '%20', $url);

         //$url = urlencode($message);
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         $response = curl_exec ($ch);
         $err = curl_error($ch);  //if you need
         curl_close ($ch);
          //dd($response);
        

         if ($response) {
            $response = json_decode($response);
            $array = get_object_vars($response);
         }
          return $response;
    }

    public static function search_vendor($address, $service){
        $pin = Address::where('id', $address)->first();
        $pin = $pin->pin;
        //dd($pin);
        $users = User::where('role', 6)->where('service_id', $service)->where('status', 1)
                 ->whereHas('addresses', function($q) use($pin){
                    $q->where('pin', $pin);
                })
                ->with('addresses')->get();
        //dd($users);
        return $users;
    }

    public static function create_slots($request, $date){
        
        $current_date = Carbon::parse($date);        
        $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');       
        $curent_timezone = $current_date->setTimezone($timezone);

        $now_date = Carbon::now()->setTimezone($timezone);

        $start_time = $curent_timezone->copy()->setTime(8, 0, 0);
        $end_time = $curent_timezone->copy()->setTime(18, 0, 0);
        
        $slots = [];
        $user_start = $curent_timezone->copy()->addHours(2);
        

        while ($start_time->lt($end_time)) {
          array_push($slots, [$start_time->copy(), $start_time->copy()->addHours(2)]);
          $start_time->addHours(2);
        }

        foreach ($slots as $key => $value) {
          if ( $now_date->lt($value[1]) && $now_date->gt($value[0]) ) {
            for ($i=$key; $i >=0 ; $i--) { 
              unset($slots[$i]);
            }
          }
        }
        return $slots;
    }

    public static function get_valid_coupon($customer_phone, $service_id, $current_order_details){
        $customer = User::where('phone_number', $customer_phone)->first();
        $validCoupons = [];
        
        $last_order = null;
        if ($customer) {
           $last_order = Order::where('customer_id', $customer->id)->get();
        }
        //Discount on first Order        
        if (!$last_order || !$last_order->count()) {
            $price = Coupon::where('coupon', '=', 'First Order')->first();

            array_push($validCoupons, ['type'=>2, 'value'=>$price->coupon_price, 'name'=>'First Order']);
        }

        //x% off on service 1 when using service 2
        $service_details = Coupon::where('coupon','=','Service Discount')->get();
        //dd($service_details);
        $service_details = $service_details->whereIn('parameter', $last_order->pluck('service_id')->unique());
        $service_details = ($service_details->where('value', $service_id))->first();
        
        if ($service_details && $service_details->count()){
            array_push($validCoupons, ['type'=>2, 'value'=>$service_details->coupon_price, 'name'=>'Service Discount']);
        }
       // dd("kasld");
        $ser = Service::where('id', $service_id)->first();

        if ($ser->form_type==2) {
            if($last_order->where('service_id', $service_id)->count()){
                  
                  $service_details = Coupon::where('coupon', '=' ,'Laundary Discount')->get();
                  
                  $service_details = $service_details->whereIn('parameter','>=', $last_order->where('service_id', $service_id)->first()->items->sum('quantity'));
                      //$service_details = ($service_details->where('value', $current_order_details['weight']));  
                      if ($service_details->count()){
                            array_push($validCoupons, ['type'=>3, 'value'=>$service_details->coupon_price]);
                      }  
            }
        }

        $coupon = Coupon::where('coupon', '=','WeekDay Discount')->get();

        $coupon=$coupon->where('parameter', Carbon::now()->dayOfWeek)->first();
        
        //dd(Carbon::now()->dayOfWeek);

        if ($coupon && $coupon->count()){
            array_push($validCoupons, ['type'=>2, 'value'=>$coupon->coupon_price, 'name'=>'WeekDay Discount']);
        }  
        $coupon = null;
        $dis = 0;
        if (count($validCoupons)) {
            
            foreach ($validCoupons as $key => $value) {
                if ($dis<$value['value']) {
                    $dis = $value['value'];
                    $coupon = $value;
                }
            }

        }

        return $coupon;

    }   

}
