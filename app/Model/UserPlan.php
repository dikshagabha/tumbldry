<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class UserPlan extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'valid_from', 'valid_to', 'store_id', 'status'];

    public function customer(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    } 

    public function getPhoneNumberAttribute(){
    	if ($this->customer()->count()) 
        {
            return $this->customer()->first()->phone_number;
        }
        return "--";
    }

     public function getNameAttribute(){
        if ($this->customer()->count()) 
        {
            return $this->customer()->first()->name;
        }
        return "--";
    }

    public function plan(){
    	return $this->hasOne('App\Model\Plan', 'id', 'plan_id');
    } 

    public function getPriceAttribute(){
    	if ($this->plan()->count()) 
        {
            return $this->plan()->first()->price;
        }
        return "--";
    }
}

