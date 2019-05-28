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
            

            if ($item->order) {
                $pin = $item->order->store->pin;
                

                $users = User::where('role', 6)->where('service_id', $item->service_id)->where('status', 1)->whereHas('addresses', function($q) use($pin){
                    $q->where('pin', $pin);
                })->with('addresses')->get();
                if (!$users) {
                    $coordinates = ['latitude'=> $item->order->store->latitude, 'longitude'=>$item->order->store->longitude];

                    $users = User::where('role', 6)->where('service_id', $item->service_id)->where('status', 1)->whereHas('addresses',function($q){
                         $q->isWithinMaxDistance($coordinates);
                    })->with('addresses')->get();
                }
                if ($users->count()) {                    
                    $vendor = $users->first();
                    VendorItem::create(['item_id'=>$item->id, 'order_id'=>$item->order->id, 'address_id'=>$vendor->addresses->id, 'vendor_id'=>$vendor->id]);
                }                
            }
        }
    }
}
