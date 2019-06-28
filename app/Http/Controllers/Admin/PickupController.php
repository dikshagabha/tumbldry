<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\NotificationsUser as not;
use App\Http\Requests\Admin\StorePickupRequest;
use App\Model\PickupRequest;
use App\Model\Service;
use App\Model\Address;
use App\User;
use DB;
use Pusher;
use Carbon\Carbon;
class PickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $activePage = 'pickup-request';
      $titlePage  = 'Pickup Request';
      //$timezone = session()->get('user_timezone');
      $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
      $users = PickupRequest::
               latest()->paginate(10);
      if ($request->ajax()) {
        //dd($users);
        return view('admin.pickup-request.list', compact('users', 'activePage', 'titlePage', 'timezone'));

      }
      return view('admin.pickup-request.index', compact('users', 'activePage', 'titlePage', 'timezone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $activePage = 'pickup-request';
      $titlePage  = 'Pickup Request';
      $services = Service::pluck('name', 'id');
      return view('admin.pickup-request.create', compact('users', 'activePage', 'titlePage', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePickupRequest $request)
    {

      try{
        DB::beginTransaction();
        if ($request->input('customer_id')==null) {
          $user = User::create(['name'=>$request->input('name'), 
                        'email'=>$request->input('email'),
                        'phone_number'=>$request->input('phone_number'),  
                        'role'=> 4
                        ]);
          $address = Address::create(['address'=>$request->input('address'),
                            'pin'=>$request->input('pin'),
                            'city'=>$request->input('city'),
                            'state'=>$request->input('state'),
                            'user_id'=>$user->id,
                            'latitude'=>$request->input('latitude'),
                            'longitude'=>$request->input('longitude'),
                            'landmark'=>$request->input('landmark')
                          ]);

          $request->merge(['customer_id' => $user->id]);
          $request->merge(['address_id' => $address->id]);
        }


        $pin = $request->input('pin');

        $address = Address::where('pin', $pin)->pluck('user_id')->toArray();  

        $address = User::where(['role'=> 3, 'status'=>1])->whereIn('id', $address)->first();

        if (!$address) {
          $origLat = $request->input('latitude');
          $origLon = $request->input('longitude');
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
          $address = Address::whereRaw($whereRaw)
                      ->select($query)->pluck('user_id')->toArray();
        }


        $address = User::where(['role'=> 3, 'status'=>1])->whereIn('id', $address)->first();
        
        $id=null;
        if ($address) {
          $id=$address->id;
        }

        $date = Carbon::createFromFormat('Y-m-d H:i', $request->input('request_time'), $request->header('timezone'));
        $pickup = PickupRequest::create(['customer_id'=>$request->input('customer_id'),
                                'address'=>$request->input('address_id'),
                                 'store_id'=>$id, 'request_time'=>$date->setTimezone('UTC'),
                                 'request_mode'=>1, 'status'=>1, 'service'=>$request->input('service'),
                                'start_time'=>$request->input('start_time'), 'end_time'=>$request->input('end_time') ]);

        //dd($pickup);
        if ($id) {
          // Send Notification to store
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
            $pusher->trigger('my-channel', 'notification'.$id, $data); 

            $message = SMSTemplate::where('title', 'like','%Pick Up Scheduled%')->select('description')->first();
            //dd($message);
            $message = $message->description;

            $mes = str_replace('@customer_name@', $request->input('name'), $message);

            $mes = str_replace('@id@', $pickup->id, $mes);
            CommonRepository::sendmessage($request->input('phone_number'), $mes);            
        }
        

        DB::commit();
        return response()->json(["message"=>"Pickup Request successfull !", 'redirectTo'=>route('pickup-request.index')], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message"=>$e->getMessage()], 400);
        }

      

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   

    public function findCustomer(Request $request)
    {
      $validatedData = $request->validate([
          'phone_number' => 'bail|required|numeric|min:2|max:9999999999',
          ]);

      $customer = User::where('role', 4)
                  ->where('phone_number', 'like', '%'.$request->input('phone_number').'%')->first();
      
      if ($customer) {
        return response()->json(["message"=>"Customer Found!!", "customer" => $customer], 200);
      }
        return response()->json(["message"=>"Customer Not Found!!"], 400);


    }
    public function setSessionAddresses(AddressRequest $request)
    { 
     $details = $request->only('address', 'city', 'state', 'pin', 'landmark', 'latitude', 'longitude');
     if ($request->input('user_id')) {
       $details['user_id']=$request->input('user_id');
       $address = Address::create($details);
       $details['address_id']=$address->id;
     }
     $data = session()->get('address');
     if ($data) {
       array_push($data, $details);
       session()->put('address', $data);
     }else{
      session()->put('address', [$details]);
     }

     $data = session()->get('address');

     
     if ($data) {
      return response()->json(["message"=>'Address Saved', 'view'=> view('store.showMultipleAddressess', compact('data'))->render()], 200);
     }
     return response()->json(["message"=>'Address Not Saved', 'data'=>$data], 400);
    }

    public function deleteSessionAddresses(Request $request){
    $items = session('address');
    $index = $request->input('data-id')-1;
    
    unset($items[$index]);

    $items = array_values($items);
    session()->put("address", $items);

    $data = session('address');
   
    return response()->json(['message'=>'Address Deleted', 'view'=> view('store.showMultipleAddressess', compact('data'))->render()], 200);
    }


}
