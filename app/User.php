<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;
class User extends Authenticatable implements JWTSubject
{
    //use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use SoftDeletes;
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

    protected $appends = ['address', 'city', 'state', 'pin', 'latitude', 'longitude', 'landmark',
                            'address_id', 'role_type'];

    // public function address(){
    //   return $this->hasMany('App\Model\UserAddress', 'user_id', 'id');
    // }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function addresses()
    {
        return $this->hasOne('App\Model\Address', 'user_id', 'id');
    }

    public function customer_addresses()
    {
        return $this->hasMany('App\Model\Address', 'user_id', 'id');
    }


    public function notifications()
    {
        return $this->hasMany('App\Model\Notification', 'to_id', 'id');
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


    public function getRoleTypeAttribute()
    {
        if($this->role==1)
        {
            return "Admin";
        };
        if($this->role==2)
        {
            return "Franchise";
        };
        if($this->role==3)
        {
            return "Store";
        };
        if($this->role==4)
        {
            return "Customer";
        }; 

        if($this->role==5)
        {
            return "Runner";
        }; 
    }

    public function getMachineTypeAttribute()
    {
        if ($this->machines()->count()) 
        {
            return $this->machines()->first()->machine_type;
        }
        return "--";
    }

    public function getMachineCountAttribute()
    {
        if ($this->machines()->count()) 
        return $this->machines()->first()->machine_count; //some logic to return numbers

        return "--";
    }

    public function getBoilerCountAttribute()
    {
        if ($this->machines()->count()) 
        return $this->machines()->first()->boiler_count; //some logic to return numbers
        return "--";
    }

    public function getBoilerTypeAttribute()
    {
        if ($this->machines()->count()) 
        return $this->machines()->first()->boiler_type; //some logic to return numbers
        return "--";
    }

    public function getIronCountAttribute()
    {
        if ($this->machines()->count())
        return $this->machines()->first()->iron_count; //some logic to return numbers
        return "--";
    }


    public function getPropertyTypeAttribute()
    {
        if ($this->properties()->count())
        return $this->properties()->first()->property_type; //some logic to return numbers
        return "--";
    }
    public function getStoreSizeAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->store_size; //some logic to return numbers
        return "--";
    }

    public function getStoreRentAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->store_rent; //some logic to return numbers
        return "--";
    }

    public function getRentEnhacementAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->rent_enhacement; //some logic to return numbers
        return "--";
    }

    public function getRentEnhacementPercentAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->rent_enhacement_percent; //some logic to return numbers
        return "--";
    }

    public function getLandlordNameAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->landlord_name; //some logic to return numbers
        return "--";
    }

    public function getLandlordNumberAttribute()
    {
         if ($this->properties()->count())
        return $this->properties()->first()->landlord_number; //some logic to return numbers
        return "--";
    }

    public function getAccountNumberAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->account_number; //some logic to return numbers
        return "--";
    }

    public function getBankNameAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->bank_name; //some logic to return numbers
        return "--";
    }

    public function getBranchCodeAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->branch_code; //some logic to return numbers
        return "--";
    }

    public function getIfscCodeAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->ifsc_code; //some logic to return numbers
        return "--";
    }

    public function getPanCardNumberAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->pan_card_number; //some logic to return numbers
        return "--";
    }

    public function getIdProofNumberAttribute()
    {
         if ($this->account()->count())
        return $this->account()->first()->id_proof_number; //some logic to return numbers
        return "--";
    }

     public function getAddressAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->address; 
        }
        return '--';
    }

    public function getAddressIdAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->id; 
        }
        return "--";
    }
     public function getPinAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->pin; 
        }
        return "--";
    }
     public function getCityAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->city; 
        }
        return "--";///some logic to return numbers
    }
     public function getStateAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->state; 
        }
        return "--"; //some logic to return numbers
    }
     public function getLatitudeAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->latitude; 
        }
        return "--";
    }
     public function getLongitudeAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->longitude; 
        }
        return "--";
    }
    
    public function getLandmarkAttribute()
    {
        if ($this->addresses()->count()) {
            return $this->addresses()->first()->landmark; 
        }
        return "--";
    }

    public function getParentNameAttribute()
    {
        if ($this->parent()->count()) {
            return $this->parent()->first()->name; 
        }
        return "--";
    }


  
}
