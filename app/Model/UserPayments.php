<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPayments extends Model
{
    public function order(){
 		return $this->hasOne('App\Model\Order', 'id', 'order_id');
 	}
}
