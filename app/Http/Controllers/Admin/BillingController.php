<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\Items;
use App\Model\UserPayments;
use App\Model\Service;
use App\Http\Requests\Admin\StoreFrenchiseRequest;
use Carbon\Carbon;
use Excel;
use App\Exports\DemoBilling;
use App\Imports\BillingImport;
use Auth;

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
        $request->validate([
            'users'=>'bail|required|numeric',
            'sheet'=>'bail|required|file'
        ]);
        $import = Excel::import(new BillingImport($request->input('users')), $request->file('sheet'));
        
        return response()->json(['message'=>'Data Imported.'], 200);
    }

    public function carryForward(Request $request)
    {

       $request->validate([
            'user'=>'bail|required|numeric',
            'price'=>'bail|required|numeric|min:1|max:30000'
        ]);
       UserPayments::insert(['user_id'=>$request->input('user'), 'order_id'=>0,
                             'price'=>$request->input('price'), 'to_id'=>Auth::user()->id, 'type'=>52, 'created_at'=>Carbon::now(), 'modified_at'=>Carbon::now()]);

       return response()->json(['message'=>'Data Saved.'], 200);
    }
}
