<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table="addresses";

    protected $fillable = ['pin', 'address', 'state', 'city', 'landmark', 'latitude', 'longitude', 'user_id'];

    public function scopeIsWithinMaxDistance($query, $coordinates, $radius = 100000000) {

	    $haversine = "(6371 * acos(cos(radians(" . $coordinates['latitude'] . ")) 
	                    * cos(radians(`latitude`)) 
	                    * cos(radians(`longitude`) 
	                    - radians(" . $coordinates['longitude'] . ")) 
	                    + sin(radians(" . $coordinates['latitude'] . ")) 
	                    * sin(radians(`latitude`))))";

	    return $query->select('*')
                 ->selectRaw("{$haversine} AS distance");
                 //->whereRaw("{$haversine} < ?", [$radius]);
        }
}
