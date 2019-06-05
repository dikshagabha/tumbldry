<?php

use Illuminate\Database\Seeder;
use App\Model\Service;

class AddCouponsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       $service = Service::where('form_type', 1)->first();
       $service1 = Service::where('form_type', 2)->first();

       //dd($service);

        DB::table('coupons')->insert([
            ['coupon' => 'First Order',
                         'coupon_price'=>10, 'parameter'=>null, 'value'=>null],
            ['coupon' => 'Service Discount',
                         'coupon_price'=>10, 'parameter'=>$service->id, 'value'=>$service1->id],
            ['coupon' => 'Laundary Discount',
                         'coupon_price'=>10, 'parameter'=>5, 'value'=>null],
            ['coupon'=>'WeekDay Discount',  'coupon_price'=>10, 'parameter'=>3, 'value'=>null]

             
            
        ]);
    }
}
