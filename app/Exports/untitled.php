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
    }
}
