<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DemoCarry implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
       // $items =  new Collection(['store_id', 'price', 'date']);
        return [['store_id', 'price', 'date']];
    }
}
