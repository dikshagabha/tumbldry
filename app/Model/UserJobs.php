<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserJobs extends Model
{
    protected $fillable = ['order_id', 'user_id', 'type', 'status', 'start_time', 'end_time', 'rating', 'assigned_by'];


    public function store_details(){
      return $this->hasOne('App\User', 'id', 'assigned_by');
    }

    public function order_details(){
      return $this->hasOne('App\Model\PickupRequest', 'id', 'order_id');
    }
}
