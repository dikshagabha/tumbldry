<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
     protected $fillable=['property_type', 'store_size', 'user_id', 'landlord_number','store_rent',
							'landlord_name','rent_enhacement_percent', 'rent_enhacement'];
}
