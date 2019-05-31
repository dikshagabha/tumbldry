<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['user_id', 'otp', 'expiry'];

    protected $dates = ['expiry'];
}
