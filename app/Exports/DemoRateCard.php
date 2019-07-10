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
class DemoRateCard implements FromCollection
{
    protected $service;
    public function __construct($service){

        $this->service = $service;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $service = Service::where('id', $this->service)->first();

        $items = Items::where('type', $service->form_type)->where('status',1)->select('name')->get();
        $items->prepend(['Item', 'Price']);
        return $items;
    }
}
