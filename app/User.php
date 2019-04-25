<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'store_name', 'phone_number', 'role', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['machine_count'];

    // public function address(){
    //   return $this->hasMany('App\Model\UserAddress', 'user_id', 'id');
    // }

    public function addresses()
    {
        return $this->hasOne('App\Model\Address', 'user_id', 'id');
    }

    public function machines()
    {
        return $this->hasOne('App\Model\UserMachines', 'user_id', 'id');
    }

    public function properties()
    {
        return $this->hasOne('App\Model\UserProperty', 'user_id', 'id');
    }

    public function account()
    {
        return $this->hasOne('App\Model\UserAccount', 'user_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    public function getMachineTypeAttribute()
    {
        return $this->machines()->first()->machine_type; //some logic to return numbers
    }
    public function getMachineCountAttribute()
    {
        return $this->machines()->first()->machine_count; //some logic to return numbers
    }

    public function getBoilerCountAttribute()
    {
        return $this->machines()->first()->boiler_count; //some logic to return numbers
    }

    public function getBoilerTypeAttribute()
    {
        return $this->machines()->first()->boiler_type; //some logic to return numbers
    }

    public function getIronCountAttribute()
    {
        return $this->machines()->first()->iron_count; //some logic to return numbers
    }


    public function getPropertyTypeAttribute()
    {
        return $this->properties()->first()->property_type; //some logic to return numbers
    }
    public function getStoreSizeAttribute()
    {
        return $this->properties()->first()->store_size; //some logic to return numbers
    }

    public function getStoreRentAttribute()
    {
        return $this->properties()->first()->store_rent; //some logic to return numbers
    }

    public function getRentEnhacementAttribute()
    {
        return $this->properties()->first()->rent_enhacement; //some logic to return numbers
    }

    public function getRentEnhacementPercentAttribute()
    {
        return $this->properties()->first()->rent_enhacement_percent; //some logic to return numbers
    }

    public function getLandlordNameAttribute()
    {
        return $this->properties()->first()->landlord_name; //some logic to return numbers
    }

    public function getLandlordNumberAttribute()
    {
        return $this->properties()->first()->landlord_number; //some logic to return numbers
    }

    public function getAccountNumberAttribute()
    {
        return $this->account()->first()->account_number; //some logic to return numbers
    }

    public function getBankNameAttribute()
    {
        return $this->account()->first()->bank_name; //some logic to return numbers
    }

    public function getBranchCodeAttribute()
    {
        return $this->account()->first()->branch_code; //some logic to return numbers
    }

    public function getIfscCodeAttribute()
    {
        return $this->account()->first()->ifsc_code; //some logic to return numbers
    }

    public function getPanCardNumberAttribute()
    {
        return $this->account()->first()->pan_card_number; //some logic to return numbers
    }

    public function getIdProofNumberAttribute()
    {
        return $this->account()->first()->id_proof_number; //some logic to return numbers
    }

     public function getAddressAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->address; 
        }
        return '';
    }
     public function getPinAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->pin; 
        }
        return '';
    }
     public function getCityAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->city; 
        }
        return '';//some logic to return numbers
    }
     public function getStateAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->state; 
        }
        return ''; //some logic to return numbers
    }
     public function getLatitudeAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->latitude; 
        }
        return '';
    }
     public function getLongitudeAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->longitude; 
        }
        return '';
    }
    
    public function getLandmarkAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->landmark; 
        }
        return '';
    }

    public function getParentNameAttribute()
    {
        if ($this->parent()->count()) {
            return $this->parent()->first()->name; 
        }
        return '';
    }


  
}
