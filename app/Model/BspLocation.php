<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BspLocation extends Model
{
    protected $fillable = ['bsp', 'operator', 'service', 'city'];
}
