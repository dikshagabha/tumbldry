<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\Items;
use App\Model\Coupon;
use App\Model\Service;
use App\Http\Requests\Admin\StoreFrenchiseRequest;
use Carbon\Carbon;
use Excel;
use App\Exports\DemoBilling;
use App\Imports\BillingImport;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activePage = 'billing';
        $titlePage  = 'Billing';
        $users = User::where('role', 3)->pluck('store_name', 'id');
        return view('admin.billing.index', compact('users', 'titlePage', 'activePage'));
    }

    public function downloadExcel(Request $request)
    {
       return  Excel::download(new DemoBilling, 'sheet.xlsx');
    }

    public function importBilling(Request $request)
    {

        $path = $request->file('sheet')->getRealPath();
        
        $import = Excel::import(new BillingImport($request->input('users')), $request->file('sheet'));
        
        return response()->json(['message'=>'Data Imported.'], 200);
    }
}
