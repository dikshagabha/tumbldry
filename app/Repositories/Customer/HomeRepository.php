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
            
             $response = CommonRepository::sendmessage($phone, $pswd);
	       
             if( $response->status == 'success') {
                DB::commit();
                return ["message"=>"Customer Added", 'redirectTo'=>route('manage-customer.index'), 'http_status'=>200];  
            }
        	return ["message"=>'Something Went Wrong!', 'http_status'=>400];
	    }
	    catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
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
                array_push($data, $value);
            }
            $address =  Address::insert($data);
	        DB::commit();
	        return ["message"=>"Customer Updated", 'redirectTo'=>route('manage-customer.index'), 'http_status'=>200];
      }
      catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
      }      
    }

     public static function login($request)
    {
        // get the user email
        $credentials = $request->only('email', 'password');
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

            // $common = new CommonRepositary;
            // $common->getManageToken($token, $user->id); // save the token in the database

            $response['http_status'] = 200;
            $response['data'] = $user;
            $response['message'] = 'User logged in successfully';
        } else {
            $response['message'] = 'Please enter valid credentials';
            $response['http_status'] = 400;
        }

        return $response;
    }
}
