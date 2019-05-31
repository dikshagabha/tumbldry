<?php

use Illuminate\Database\Seeder;
use App\Model\SMSTemplate;
class SMStemplatesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('s_m_s_templates')->insert([
            ['title' => 'Pick Up Scheduled',
                        'description'=>'Hi @customer_name@\nYour pick up request @id@ is confirmed. You will get an alert once the executive is on the way. For queries call 18001031831.'],
          	['title' => 'Runner out for Pick Up',
                        'description'=>'Executive @runner_name@ (@phone_number@) is out for pick up. Allow the executive to leave post order confirmation via SMS. For queries call 18001031831.'],
           ['title' => 'Order Created',
                        'description'=>'Hi @customer_name@\nYour order @order_id@ of @total_clothes@ clothes@weight@ for @service@ created. For queries call 18001031831.'],

            ['title' => 'Order Ready for Delivery',
                        'description'=>'Hi @customer_name@\nYour order @order_id@ is ready for store pick up. Pick up from 8am-8pm. Call 0120 1234567 for home delivery. For queries call 18001031831.'],
            ['title' => 'Order Created',
            'description'=>'Hi @customer_name@\nExecutive @runner_name@ (@phone_number@) is out to deliver order 1234567. You will get an SMS link if you wish to pay online. For queries call 18001031831.

'],
            ['title' => 'Order Delivered',
            'description'=>'Hi @customer_name@\nYour order @order_id@ is delivered. Please access your invoice on www.tumbledryinvoice.in. For queries call 18001031831.'],

            ['title' => 'Loyalty Points Earned',
            'description'=>'Hi @customer_name@\nCongratulations! You just earned @points@ points on order @order_id@. Your points balance is @total@. Pay online on next order to redeem & earn more points.'],
            ['title' => 'Loyalty Points Expiry',
            'description'=>'Hi @customer_name@\nYour @points@ points will expire on @date@ Order now & pay online to redeem these points, and earn more.'],

        ]); 
    }
}
