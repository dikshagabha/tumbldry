<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class UserMachines extends Model
{
    protected $fillable=['boiler_count', 'machine_count', 'user_id', 'machine_type','iron_count',
							'boiler_type'];
}
