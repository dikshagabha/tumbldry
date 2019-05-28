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

class assignVendor implements ShouldQueue
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
        $items = OrderItems::where('status', 1)->with(['order'=>function($q){
            $q->with('store');
        }])->get();

        foreach ($items as $key => $item) {
            
            if (VendorItem::where('item_id', $item->id)->where('deleted_at', null)->count()) {
                return;
            }

            if ($item->order) {
                $pin = $item->order->store->pin;               

                $users = User::where('role', 6)->where('service_id', $item->service_id)->where('status', 1)
                ->whereHas('addresses', function($q) use($pin){
                    $q->where('pin', $pin);
                })
                ->with('addresses')->first();
                if (!$users) {
                    $coordinates = ['latitude'=> $item->order->store->latitude, 'longitude'=>$item->order->store->longitude];
                    if ($item->order->store->latitude && $item->order->store->longitude) 
                    {
                         $haversine = "(6371 * acos(cos(radians(" . $coordinates['latitude'] . ")) 
                        * cos(radians(`latitude`)) 
                        * cos(radians(`longitude`) 
                        - radians(" . $coordinates['longitude'] . ")) 
                        + sin(radians(" . $coordinates['latitude'] . ")) 
                        * sin(radians(`latitude`))))";
                        $users = User::where('role', 6)->where('service_id', $item->service_id)->where('status', 1)->with(['addresses'=>function($query) use ($coordinates, $haversine){
                    
                                            $query->select('*')
                                                ->selectRaw("{$haversine} AS distance");
                                             //$q->isWithinMaxDistance($coordinates);
                                        }
                        ])->get();
                    }                   
                }
                if ($users && $users->count()) {                    
                    $vendor = $users->first();
                    //print_r($vendor->addresses);

                    $vendor = VendorItem::create(['item_id'=>$item->id, 'order_id'=>$item->order->id, 'address_id'=>$vendor->addresses->id, 'vendor_id'=>$vendor->id, 'service_id'=>$item->service_id]);
                }                
            }
        }
    }
}
