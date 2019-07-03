<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Model\{
	Service,
	UserPayments,
    Items
};
use Auth;
use Carbon\Carbon;
class DemoBilling implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = Items::where('type', 11)->select('name')->get();
        $items->prepend(['Item', 'Price']);
        return $items;
    }
}
