<?php

namespace App\Repositories\Customer;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\User;
use App\Model\Address;
use DB;
use Auth;
use App\Repositories\CommonRepository;
use JWTAuth;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

use App\Model\Otp;
/**
 * Class HomeRepository.
 */
class HomeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }


    public static function store($request, $user, $address)
    {
        if (!$address) {
            return ["message"=>"Please enter an address.", 'http_status'=>400];
        }
	    try {
	        DB::beginTransaction();
	        $pswd=CommonRepository::random_str();

	        $phone = $request->input('phone_number');
	        $user = User::create(['name'=>$request->input('name'), 'role'=>4, 'email'=> $request->input('email'), 
	        						'password'=>bcrypt($pswd), 'phone_number'=> $request->input('phone_number'), 
	        						'user_id'=>$user, 'status'=>1]);

            $data = [];
            foreach ($address as $key => $value) {
                $value['user_id']=$user->id;
                array_push($data, $value);
               
            }
	        $address =  Address::insert($data);
            
            //$response = CommonRepository::sendmessage($phone, $pswd);
	       
            // if( $response->status == 'success') {
                DB::commit();
                return ["message"=>"Customer Added", 'redirectTo'=>route('manage-customer.index'), 'http_status'=>200,
                            'code'=>1, 'msg'=>'Success', 'details'=>['data'=>$user]];  
            //}
        	//return ["message"=>'Something Went Wrong!', 'http_status'=>400];
	    }
	    catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400, 'code'=>2, 'msg'=>'Error'];
	    }        
    }

    public static function update($request, $id, $user, $address)
    {
	   try {
	        DB::beginTransaction();	        
	        $user_update = User::where('id', $id)->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'phone_number'=>$request->input('phone_number')]);

	        $ad = Address::where('user_id', $id)->delete();
            //print_r($id);
            $data = [];
            foreach ($address as $key => $value) {
                $value['user_id']=$id;
                $value['created_at']=Carbon::now();
                $value['updated_at']=Carbon::now();
                array_push($data, $value);
            }
            $address =  Address::insert($data);
	        DB::commit();
	        return ["message"=>"Customer Updated", 'redirectTo'=>route('manage-customer.index'), 'http_status'=>200,
                        'code'=>1, 'msg'=>'Success', 'details'=>['data'=>$user]
                    ];
      }
      catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400, 'code'=>2, 'msg'=>'Error'];
      }      
    }

     public static function login($request)
    {
        // get the user email
        $credentials = $request->only('phone_number', 'password');
        $credentials['role'] = 4;
        $credentials['status'] = 1;
        //dd(JWTAuth::attempt($credentials));
        // attempt to verify the credentials and a token for the user
        if ($token = JWTAuth::attempt($credentials)) {
            
            // token generated successfully
            $response = compact('token');
            // find the user
            $user = Auth::user()->load([
                'addresses']);

            $user->device_token = $request->input('device_token', '');
            $user->last_login = Carbon::now();
            $user->save(); // save the user (update the device token)
            CommonRepository::getManageToken($token, $user->id);

            $response['http_status'] = 200;
            $response['details'] = $user;
            $response['message'] = 'User logged in successfully';
        } else {
            $response['message'] = 'Please enter valid credentials';
            $response['http_status'] = 400;
        }

        return $response;
    }

     public static function sendOtp($request)
    {
        $user = User::where('phone_number', $request->input('phone_number'))->first();
        
        $otp = rand(0000, 9999);
        
        if ( $user ) {
            if ($user->role != 4) {
                return ['message'=>'The phone number has already been taken for another user.', 'code'=>2 , 
                            'http_status'=>400];
            }
        }
        if (!$user) {
            $user = User::create(['phone_number'=>$request->input('phone_number')]);
        }
        $res = CommonRepository::sendmessage($request->input('phone_number'), "Hi $user->name,\n The otp for your login is ".$otp.".");

        $user->password = bcrypt($otp);
        $user->save();

        if ($otp) {
            return ['message'=>'Success', 'code'=>1, 'details'=>['otp'=>$otp], 'http_status'=>200];
        }
        return ['message'=>'Something Went Wrong!', 'code'=>2 , 'http_status'=>400];
    }

    public static function verifyOtp($request)
    {
        $user = User::where('phone_number', $request->input('phone_number'))->whereRole(5)->first();
        if (!$user) {
            return ['message'=>'runner not found.', 'http_status'=>400];
        }
        $otp = Otp::where(['user_id'=>$user->id, 'otp'=>$request->input('otp')])->first();
        
        $user->password = bcrypt($request->input('otp'));
        $user->save();

        if($otp){
              // if ($otp->expiry->lt(Carbon::now())) {
              //   return ['message'=>'Otp has expired.', 'http_status'=>200];
              // }
              $otp->delete();
            return ['message'=>'Success', 'http_status'=>200, 'code'=>1];
        }
        return ['message'=>'Something Went Wrong!', 'code'=>2, 'http_status'=>400];
    }
}
