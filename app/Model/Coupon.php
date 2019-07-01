<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['title', 'coupon_price', 'parameter', 'value'];
}
