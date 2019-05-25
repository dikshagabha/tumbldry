<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\NotificationsUser as not;
use App\Http\Requests\Store\StorePickupRequest;
use App\Model\PickupRequest;
use App\Model\Service;
use App\Model\Address;
use App\User;
use DB;
use Pusher;
use Auth;
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
               latest()->where('store_id', Auth::user()->id)->paginate(10);
      if ($request->ajax()) {
        //dd($users);
        return view('store.pickup-request.list', compact('users', 'activePage', 'titlePage', 'timezone'));

      }
      return view('store.pickup-request.index', compact('users', 'activePage', 'titlePage', 'timezone'));
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
      $services = Service::where('type', 1)->pluck('name', 'id');
      return view('store.pickup-request.create', compact('users', 'activePage', 'titlePage', 'services'));
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

          $address = session()->get('address');
          $address['user_id'] = $user->id;
          $address = Address::create($address);

          $request->merge(['customer_id' => $user->id]);
          $request->merge(['address_id' => $address->id]);
        }
        $id= Auth::user()->id;

        $date = Carbon::createFromFormat('Y-m-d H:i', $request->input('request_time'), $request->header('timezone'));
        $pickup = PickupRequest::create(['customer_id'=>$request->input('customer_id'),
                                'address'=>$request->input('address_id'),
                                 'store_id'=> $id, 'request_time'=>$date->setTimezone('UTC'),
                                'request_mode'=>1, 'status'=>1, 'service'=>$request->input('service')]);

        //dd($pickup);
        //if ($id) {
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
        //}
        

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



}
