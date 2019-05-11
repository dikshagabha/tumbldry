<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['pickup_id', 'customer_id', 'address_id','runner_id', 'store_id', 'status',
 							'estimated_price'];
 							
}
