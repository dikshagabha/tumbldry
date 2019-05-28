<?php

namespace App\Repositories\Vendor;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\User;
use App\Model\Address;
use DB;
use Auth;
use App\Repositories\CommonRepository;
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

    public static function store($request, $user,  $address, $providers)
    {
	    try {
	        DB::beginTransaction();
	        $pswd=CommonRepository::random_str();
	        $phone = $request->input('phone_number');
	        $user = User::create(['name'=>$request->input('name'), 'role'=>6, 'email'=> $request->input('email'), 
	        						'password'=>bcrypt($pswd), 'phone_number'=> $request->input('phone_number'), 
	        						'user_id'=>$user->id, 'store_name'=>$request->input('store_name'),'status'=>1, 'service_id'=>$request->input('service_id')]);

	        $address['user_id']=$user->id;
	        $address =  Address::create($address);

	        foreach ($providers as $key => $value) {
	        	//dd($providers);
	        	$value['role']=7;
	        	$value['status']=1;
	        	$value['user_id']=$user->id;
	        	$provider = User::create($value);
	        	$add = $value['address'];
	        	//dd($provider->id);
	        	$add['user_id']=$provider->id;
	        	$add['role']=7;
	        	//dd($value);
	        	$add = Address::create($add);
	        }

            DB::commit();
	        return ["message"=>"Vendor Added", 'redirectTo'=>route('manage-vendor.index'), 'http_status'=>200];	
        }
	    catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
	    }        
    }

    public static function update($request, $id, $address, $providers)
    {
	   try {
	        DB::beginTransaction();
	        
	        $user = User::where('id', $id)->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'phone_number'=>$request->input('phone_number'), 'store_name'=>$request->input('store_name'), 'service_id'=>$request->input('service_id')]);

	        if ($address) {
	        	$address = Address::where('id', $request->input('address_id'))->update($address);
	        }	        
	        if($providers)
	        {
	        	foreach ($providers as $key => $value) {
	        	$value['role']=7;
	        	$value['status']=1;
	        	$value['user_id']=$id;
	        	$provider = User::create($value);
	        	$add = $value['address'];
	        	$add['user_id']=$provider->id;
	        	$add['role']=7;
	        	$add = Address::create($add);
	        	}
	        }
	        DB::commit();
	        return ["message"=>"Runner Updated", 'redirectTo'=>route('manage-vendor.index'), 'http_status'=>200];
     }
      catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
      }      
    }
}
