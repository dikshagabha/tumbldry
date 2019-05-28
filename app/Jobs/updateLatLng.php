<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use App\Model\{
    Order,
    OrderItems,
    VendorItem,
    Address

};

use App\User;

class updateLatLng implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $address = Address::where(["latitude" => null, "longitude" => null])->get();
        if ($address->count()) {
            foreach ($address as $add) {
                $latlmg = '' . $add->address . ' ' . $add->city . ' ' . $add->state . ' ' . $add->country . ' ' . $add->pin;
                if (trim($latlmg)) {
                    $lat_lng = self::getLatandLong($latlmg);
                    Address::where("id", $add->id)->update([
                        "latitude" => $lat_lng["lat"],
                        "longitude" => $lat_lng["lng"]
                    ]);
                }
            }
        }
    }


     public function getLatandLong($zip = null)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&key=AIzaSyBMCcwLnUryNyEfPVES4lQhKd1QhaCAfO8&sensor=false";
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);
        $result = json_decode($result, true);
        if (($result['status'] == 'OK')) {
            $lat_lng = $result['results'][0]['geometry']['location'];
        } else {
            $lat_lng['lat'] = '';
            $lat_lng['lng'] = '';
        }
        return $lat_lng;
    }
}
