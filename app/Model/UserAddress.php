<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table="useraddess";

    protected $fillable = ['user_id', 'address_id'];

    public function addressdetails(){
      return $this->hasOne('App\Model\Address', 'id','address_id');
    }

}
