<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = ['user_id', 'order_id', 'to_id', 'type', 'price', 'loyality_points'];
}
