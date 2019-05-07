<?php

namespace App\Repositories\Store;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\User;
use App\Model\Address;
use App\Model\UserAddress;
use App\Model\UserAccount;
use App\Model\UserProperty;
use App\Model\UserMachines;
use App\Model\UserImages;
use App\Model\StoreFields;
use DB;
/**
 * Class HomeRepository.
 */
class HomeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public static function store($request)
    {
	    try {
	        DB::beginTransaction();

	        $user = User::create(['name'=>$request->input('name'), 'role'=>3, 'email'=> $request->input('email')
	                            , 'phone_number'=> $request->input('phone_number'), 'store_name'=> $request->input('store_name'), 'user_id'=>$request->input('user_id')]);
	        $machines =  UserMachines::create([
	                                          'user_id'=>$user->id,
	                                          'machine_count'=>$request->input('machine_count'),
	                                          'boiler_count'=>$request->input('boiler_count'),
	                                          'machine_type'=>$request->input('machine_type'),
	                                          'boiler_type'=>$request->input('boiler_type'),
	                                          'iron_count'=>$request->input('iron_count') ,
	                                          ]);
	        $property =  UserProperty::create([
	                                          'user_id'=>$user->id,
	                                          'property_type'=>$request->input('property_type'),
	                                          'store_size'=>$request->input('store_size') ,
	                                          'store_rent'=>$request->input('store_rent'),
	                                          'landlord_number'=>$request->input('landlord_number'),
	                                          'landlord_name'=>$request->input('landlord_name'),
	                                          'rent_enhacement_percent'=>$request->input('rent_enhacement_percent') ,
	                                          'rent_enhacement'=>$request->input('rent_enhacement'),
	                                          ]);

	        $account =  UserAccount::create([
	                                          'account_number'=>$request->input('account_number') ,
	                                          'user_id'=>$user->id,
	                                          'bank_name'=>$request->input('bank_name'),
	                                          'branch_code'=>$request->input('branch_code'),
	                                          'ifsc_code'=>$request->input('ifsc_code'),
	                                          'gst_number'=>$request->input('gst_number') ,
	                                          'pan_card_number'=>$request->input('pan_card_number'),
	                                          'id_proof_number'=>$request->input('id_proof_number'),
	                                          ]);

	        $address =  Address::create([
	                                      'address'=>$request->input('address') ,
	                                      'user_id'=>$user->id,
	                                      'city'=>$request->input('city'),
	                                      'state'=>$request->input('state'),
	                                      'pin'=>$request->input('pin'),
	                                      'latitude'=>$request->input('latitude') ,
	                                      'longitude'=>$request->input('longitude'),
	                                      'landmark'=>$request->input('landmark'),
	                                      ]);
	        $img_array =['user_id'=>$user->id];
	        foreach (['address_proof', 'gst_certificate', 'bank_passbook', 'cheque', 'pan', 'id_proof',
	                    'loi_copy', 'agreement_copy', 'rent_agreement', 'transaction_details'] as $key => $value)
	        {
	             if($request->file($value))
	             {

	                $image = $request->file($value);
	                $name=$image->getClientOriginalName().time().$user->id;
	                $image->move(public_path().'/uploaded_images/', $name);   
	                array_push($img_array, [$value=>$name]);
	                       
	             }
	         }

	         
	        $images =  UserImages::create($img_array);
	        DB::commit();
	        return ["message"=>"Store Added", 'redirectTo'=>route('manage-store.index'), 'http_status'=>200];
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
	        $user = User::where('id', $id)->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'phone_number'=>$request->input('phone_number'),'user_id'=>$request->input('user_id'),
	                                                       'store_name'=>$request->input('store_name')]);
	        
	       
	        $machines =  UserMachines::where('user_id', $id)->update(
	          $request->only(['machine_count','boiler_count', 'machine_type', 'boiler_type', 'iron_count']));
	        $property =  UserProperty::where('user_id', $id)->update(
	          $request->only(['property_type','store_size', 'store_rent','landlord_number', 'landlord_name', 'rent_enhacement_percent', 'rent_enhacement']));

	        $account =  UserAccount::where('user_id', $id)->update(
	          $request->only(['account_number','bank_name','branch_code','ifsc_code', 'gst_number', 'pan_card_number', 'id_proof_number']));

	        $account =  Address::where('user_id', $id)->update(
	          $request->only(['address','city','state','pin', 'latitude', 'longitude', 'landmark']));

	        $img_array =[];

	         foreach (['address_proof', 'gst_certificate', 'bank_passbook', 'cheque', 'pan', 'id_proof',
	                    'loi_copy', 'agreement_copy', 'rent_agreement', 'transaction_details'] as $key => $value)
	         {  
	          if($request->file($value))
	             {

	                $image = $request->file($value);
	                $name=$image->getClientOriginalName().time().$user->id;
	                $image->move(public_path().'/uploaded_images/', $name);   
	                array_push($img_array, [$value=>$name]);
	                       
	             }
	         }

	         
	        $images =  UserImages::where('user_id', $id)->update($img_array);
	        DB::commit();
	        return ["message"=>"Store Updated", 'redirectTo'=>route('manage-store.index'), 'http_status'=>200];
      }
      catch (\Exception $e) {
	        DB::rollback();
	        return ["message"=>$e->getMessage(), 'http_status'=>400];
      }      
    }
}
