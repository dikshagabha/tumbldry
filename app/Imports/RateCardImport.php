<?php

namespace App\Imports;
use App\Model\Items;
use App\Model\ServicePrice;

use App\Model\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Auth;
class RateCardImport implements ToCollection
{

    public $service;
    public $city;
    public function __construct($service, $city)
    {

        $this->service=$service;
        $this->city=$city;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $payment = [];

        $service = Service::where('id', $this->service)->first();

        $items = Items::where('type', $service->form_type)->where('status',1)->get();
        $rows=$rows->slice(1);
       // dd($rows);
        foreach ($rows as $row) 
        {
            $item_id = $items->where('name', 'like', $row[0])->first();
            if (!$item_id) {
                $item_id = Items::create(['name'=>$row[0], 'type'=>$service->form_type, 'status'=>1]);
            }
            if ($item_id && $row[1]) {                
                $item_id = $item_id->id;
                $prev = ServicePrice::where(['service_id'=>$this->service, 'parameter'=>$item_id,'location'=>$this->city])->first();

                if ($prev) {
                    $update = ServicePrice::where('id',$prev->id)->update(['service_id'=>$this->service, 'parameter'=>$item_id, 'value'=>$row[1], 'updated_at'=>Carbon::now(), 'quantity'=> 1,
                    'location'=>$this->city, 'service_type'=>$service->form_type]);
                    continue;
                }
                array_push($payment, ['service_id'=>$this->service, 'parameter'=>$item_id, 'value'=>$row[1],
                    'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now(), 'quantity'=> 1,
                    'location'=>$this->city, 'service_type'=>$service->form_type]);
            }
        }
        if (count($payment)) {
           ServicePrice::insert($payment);
        }
        
        return $payment;
    }
}
 