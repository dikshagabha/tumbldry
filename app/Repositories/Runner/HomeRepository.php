<?php

namespace App\Repositories\Runner;

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
      
    }


    public static function store($request, $user)
    {
	    try {
	        DB::beginTransaction();
	        $pswd=CommonRepository::random_str();

	        $phone = $request->input('phone_number');


	        $user = User::create(['name'=>$request->input('name'), 'role'=>5, 'email'=> $request->input('email'), 
	        						'password'=>bcrypt($pswd), 'phone_number'=> $request->input('phone_number'), 
	        						'user_id'=>$user, 'status'=>1]);
                  //CommonRepository::sendmessage($request->input('phone_number'), 'Welcome to Tumbedry. The password for your account is $pswd');
              DB::commit();
		          return ["message"=>"Runner Added", 'redirectTo'=>route('manage-runner.index'), 'http_status'=>200];	
             //}
        	return ["message"=>'Something Went Wrong!', 'http_status'=>400];
	    }
	    catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
	    }        
    }

    public static function update($request, $id)
    {
	   try {
	        DB::beginTransaction();
	        
	        $user = User::where('id', $id)->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'phone_number'=>$request->input('phone_number')]);

	        // $account =  Address::where('user_id', $id)->update(
	        //   $request->only(['address','city','state','pin', 'latitude', 'longitude', 'landmark']));
	        DB::commit();
	        return ["message"=>"Runner Updated", 'redirectTo'=>route('manage-runner.index'), 'http_status'=>200];
      }
      catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
      }      
    }

    public static function login($request)
    {
        // get the user email
        $credentials = $request->only('phone_number', 'password');
        $credentials['role'] = 5;
        $credentials['status'] = 1;
        //dd(JWTAuth::attempt($credentials));
        // attempt to verify the credentials and a token for the user
        if ($token = JWTAuth::attempt($credentials)) {
            // token generated successfully
            //$response = compact('token');
            // find the user
            $user = Auth::user()->load([
                'addresses']);

            $user->device_token = $request->input('device_id', '');
            $user->last_login = Carbon::now();
            $user->save(); // save the user (update the device token)

            //$common = new CommonRepositary;
            CommonRepository::getManageToken($token, $user->id); // save the token in the database

            $response['http_status'] = 200;
            $response['code'] = 1;
            $response['details'] = ['token'=>$token, 'info'=>$user];

            $response['message'] = 'Success';
        } else {
            
            $response['message'] = 'Please enter valid credentials';
            $response['http_status'] = 400;
           // $response['http_status'] = 200;
            $response['code'] = 2;
        }

        return $response;
    }

    public static function sendOtp($request)
    {
        $user = User::where('phone_number', $request->input('phone_number'))->whereRole(5)->first();
        if (!$user) {
            return ['message'=>'runner not found.', 'http_status'=>400];
        }
        $otp = rand(0000, 9999);
        $otp = 1234;
        $otp = Otp::create(['user_id'=>$user->id, 'otp'=> $otp, 'expiry'=>Carbon::now()->addMinutes(15)]);

        //$res = CommonRepository::sendmessage($request->input('phone_number'), "Hi%20$user->name%20\n%20The%20otp%20for%20your%20login%20is%20$otp.");
        if ($otp) {
            return ['message'=>'Success', 'code'=>1, 'details'=>['otp'=>$otp->otp]];
        }

        return ['message'=>'Something Went Wrong!', 'code'=>2];
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
        return ['message'=>'Something Went Wrong!', 'code'=>2];
    }
}
