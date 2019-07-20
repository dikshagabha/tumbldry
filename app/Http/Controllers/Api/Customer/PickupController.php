<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\HomeRepository;
use JWTAuth;
use App\Requests\Customer\Auth\UpdateRequest;
use App\User;
use App\Model\{
    Address
};

class PickupController extends Controller
{
    
	protected $user;

    /**
     * Adds the Middleware to chekc whether the user is logged in or not
     */
    public function __construct()
    {
        // check the user is logged in or not
        $this->middleware('jwtcustom');
        // if the user is logged in then fetches the details of the user
        $this->middleware(function($request, $next) {
            $this->user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        });
    }

    public function storeSuggestions(Request $request){
      $stores=[];
      if ($request->input('address_id')) {
        $user_add = Address::where('id', $request->input('address_id'))->first();
        $pin = $user_add->pin;
        $latitude = $user_add->latitude;
        $longitude = $user_add->longitude;
      
      }elseif($request->input('address')){
        $user_add = $request->input('address');
        $pin = $user_add['pin'];
        $latitude = $user_add['latitude'];
        $longitude = $user_add['longitude'];
      }else{
        return response()->json(['message'=>'Please enter address'], 400);
      }
      $address = Address::where('pin', $pin)->pluck('user_id')->toArray();
      $address = User::where(['role'=> 3, 'status'=>1])->whereIn('id', $address)->limit(5)->get();

      if (!$address->count()) {
          $origLat = $latitude;
          $origLon = $longitude;
          $dist = 10; 
          $query = "SELECT user_id, latitude, longitude, 3956 * 2 * 
                    ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
                    +COS($origLat*pi()/180 )*COS(latitude*pi()/180)
                    *POWER(SIN(($origLon- longitude)*pi()/180/2),2))) 
                    as distance ";
          $whereRaw = "longitude between ($origLon-$dist/cos(radians($origLat))*69) 
                      and ($origLon+$dist/cos(radians($origLat))*69) 
                      and latitude between ($origLat-($dist/69)) 
                      and ($origLat+($dist/69)) 
                         ORDER BY distance limit 1"; 
         
          if ($origLat && $origLon) {
            $address = Address::whereRaw($whereRaw)
                      ->select($query)->pluck('user_id')->toArray();
          }
          if ($address) {
           $address = User::where(['role'=> 3, 'status'=>1])->whereIn('id', $address)->limit(5)->get();
          }
        }

      $slots_all = CommonRepository::create_slots($request, $request->input('date'));
      
      foreach ($address as $key => $value) {
        $slots = $slots_all;
        $pickups  = PickupRequest::where('store_id', $value->id)->whereDate('created_at', '=',$request->input('date'))->get();
      
          if ($pickups->count()) {
            $n = User::where('user_id', $value->id)->where('role', 5)->count();
            $allowed = 4*$n;
              foreach ($slots as $key => $slot) {
                $pickup_count = $pickups->where('start_time', '=',$slot[0]->toDateTimeString())->where('end_time','=',$slot[1]->toDateTimeString())->count();
                if ($pickup_count >= $allowed) {
                  unset($slots[$key]);
                }
              }
          }
          if ($slots) {
            array_push($stores, ['store_name'=>$value->name, 'id'=>$value->id, 'slots'=>$slots,
                                  'address'=>$value->address]);
          }
      }

      return response()->json(['message'=>'Success', 'stores'=>$stores], 200);
    }

    public function createPickup(Request $request)
    {
       try{
        DB::beginTransaction();
        $pickup = PickupRequest::create(['customer_id'=>$this->user->id,
                                          'address'=>$request->input('address_id'),
                                           'store_id'=>$request->input('store'), 'request_time'=>$request->input('request_time'),
                                           'request_mode'=>1, 'status'=>1, 'service'=>$request->input('service'),
                                            'start_time'=>$request->input('start'), 'end_time'=>$request->input('end') ]);

        //dd($pickup);
        // if ($req) {
        //   // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
              $options
            );


            $data['message'] = $request->input('name')." has requested a pickup.";
            $pusher->trigger('my-channel', 'notification'.$request->input('store'), $data); 

            $message = SMSTemplate::where('title', 'like','%Pick Up Scheduled%')->select('description')->first();
            //dd($message);
            $message = $message->description;

            $mes = str_replace('@customer_name@', $request->input('name'), $message);

            $mes = str_replace('@id@', $pickup->id, $mes);
            CommonRepository::sendmessage($request->input('phone_number'), $mes);            
        //}
        DB::commit();
        return response()->json(["message"=>"Pickup Request successfull !", 'redirectTo'=>route('admin-pickup-request.index'), 
                                  "pickup"=>$pickup], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message"=>$e->getMessage()], 400);
        }
    }
}
