<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
      protected $table="addresses";

    protected $fillable = ['pin', 'address', 'state', 'city', 'landmark', 'latitude', 'longitude'];

}
