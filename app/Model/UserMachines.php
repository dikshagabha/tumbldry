<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class UserMachines extends Model
{
    protected $fillable=['boiler_count', 'machine_count', 'user_id', 'machine_type','iron_count',
							'boiler_type'];

	public function machinetype()
    {
        return $this->hasOne('App\Model\StoreFields', 'id', 'machine_type');
    }
    public function boiler()
    {
        return $this->hasOne('App\Model\StoreFields', 'id', 'boiler_type');
    }
}
