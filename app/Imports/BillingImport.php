<?php

namespace App\Imports;
use App\Model\Items;
use App\Model\UserPayments;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Auth;
class BillingImport implements ToCollection
{

    public $user;
    public function __construct($id)
    {

        $this->user=$id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $payment = [];
        $item = Items::where('type', 11)->get();
        foreach ($rows as $row) 
        {
            $item_id = $item->where('name', $row[0])->first(); 
            //dd($this->user);    
            if ($item_id) {
                    array_push($payment, ['order_id'=>$item_id->id, 'type'=>51, 'price'=>$row[1],
                        'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now(), 'to_id'=> Auth::user()->id,
                        'user_id'=>$this->user]);
                 }     
            
        }

        UserPayments::insert($payment);
        return $payment;
    }
}
 