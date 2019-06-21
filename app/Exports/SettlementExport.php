<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Model\{
	Service,
	UserPayments
};
use Auth;
use Carbon\Carbon;
class SettlementExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

    	$month = Carbon::now()->month-1;

    	$payments = UserPayments::where('to_id', Auth::user()->id)->with('order')
    					->whereMonth('created_at',$month)->whereIn('type', [1, 2, 3, 4])->get();
    	
    	$services = Service::get();
    	$laundary = $services->where('form_type', 2)->where('type', 1)->pluck('id');
    	$dryclean =  $services->where('form_type', 1)->where('type', 1)->pluck('id');
    	$other =  $services->wherenotIn('form_type', [1, 2])->where('type', 1)->pluck('id');


    	$A=$B=$C=0;

    	foreach ($payments as $key => $value) {
    		$order = $value->order;
    		if (!$order) {
    			break;    
    		}

    		// print_r($order->service_id);
    		// echo "<br>";
    		// print_r( $laundary->toArray() );


    		if (in_array($order->service_id, $laundary->toArray())) {
    			$A+=$value->price;
    		}
    		if (in_array($order->service_id, $dryclean->toArray())) {
    			$B+=$value->price;
    		}
    		if (in_array($order->service_id, $other->toArray())) {
    			$C+=$value->price;
    		}
    		//$laundary = $order->whereIn('service_id', $laundary)->count();


    	}

    	$D = $payments->where('type', '1')->sum('price');
    	$E = $payments->where('type', '4')->sum('price');
    	//die;

          return collect([
            ['Revenue', 'Price'],
            ['Laundary Services', $A],
            ['Dry Clean Services', $B],
            ['Other Services', $C],
            ['Total', $A+$B+$C],
            ['', ''],
            ['Collection', ''],
            ['Cash', $D],
            ['Online', $E],
            ['Total', $D+$E],

            ['', ''],
            ['Franchisee Share in Revenue', ''],
            ['Laundry Services', 93.5/100*$A],
            ['Dry Cleaning Services', 20/100*$B],
            ['Other Services', 20/100*$C],
            ['Total', 93.5/100*$A+20/100*$B+20/100*$C],


            ['', ''],
            ['Billing', ''],
            ['Packaging Polybag', ''],
            ['Leaflets', ''],
            ['Suit Cover', ''],
            ['Shirt Card', ''],
            ['Shirt Band', ''],
            ['Brand Table', ''],
            ['Carry bag', ''],
            ['Tshirt', ''],
            ['Cap', ''],
            ['Laundry bag', ''],
            ['Other packaging Material', ''],
            ['Emulsifier', ''],
            ['Detergent', ''],
            ['Clax Magic', ''],
            ['Oxy Bleach', ''],
            ['Gross Billing', ''],
            ['CGST', ''],
            ['SGST', ''],
            ['IGST', ''],
            ['Net Billing', ''],
            ['', ''],
            ['Franchisee payment', ''],
            ['Payable amount to Franchisee/Amount to be collected from Franchisee', ''],
            ['Carry Forward from previous Statement', ''],
            ['Net outstanding amount for Franchisee/ to be collected from Franchisee', ''],

        ]);
    }
}
