<?php

namespace App\Imports;
use App\Model\Items;
use App\Model\UserPayments;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Auth;
class CarryImport implements ToCollection
{

    public $type;
    public function __construct($id)
    {

        $this->type=$id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $payment = [];

        foreach ($rows as $row) 
        {
            $user = User::where('id', $row[0])->where('role', 3)->first();
            if ($user) {
                $type=53;
                $use = row[0];
                $to = Auth::user()->id;
                if ($this->type==1) {
                    $type=52;
                    $to = $request->input('user');
                    $use = row[0];
                }
        
                if ($item_id) {
                        array_push($payment, ['order_id'=>0, 'type'=>$type, 'price'=>$row[1],
                            'created_at'=>Carbon::parse($row[2]), 'updated_at'=>Carbon::now(), 'to_id'=> $to,
                            'user_id'=>$use]);
                     }  
            }
                  
            
        }

        UserPayments::insert($payment);
        return $payment;
    }
}
 