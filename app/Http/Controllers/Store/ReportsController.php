<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\{
	Address,
	Location,
  Order
};
use Carbon\Carbon;
use App\User;
class ReportsController extends Controller
{
    protected $user;
	protected $useraddress;
	protected $location;

	public function __construct(){
    $this->middleware(function($request, $next) {
        $this->user = Auth::user()->load('addresses');
        $this->useraddress = $this->user->addresses->first();
        $this->location = Location::where('pincode', $this->useraddress->pin)->first();
        return $next($request);
    });
  }

  public function customerReports(Request $request)
  {
    $activePage = 'reports';
    $titlePage = 'Customer Reports';
    $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
    $months = [];
    for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
     $months[$m] = $month;
     }
  	$users = User::where(['user_id'=>$this->user->id, 'role'=>4])
  			->when($request->filled('currentFilter'), function($q) use($request, $timezone){
  				$q->whereDate('created_at', '=', $request->input('currentFilter'));
  			})
  			->when($request->filled('monthFilter'), function($q) use($request){
  				$q->whereMonth('created_at', '=',$request->input('monthFilter'));
  			})
        ->latest()
  			->paginate(10);
    
  	if ($request->ajax()) {
  		return view('store.reports.customer.list', compact('users', 'timezone', 'months'));
  	}
  	return view('store.reports.customer.index', compact('users', 'activePage', 'titlePage', 'timezone', 'months'));
  }

  public function orderReports(Request $request)
  {
    $activePage = 'reports';
    $titlePage = 'Order Reports';
    $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
    $months = [];
    for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
     $months[$m] = $month;
     }
    $users = Order::where(['store_id'=>$this->user->id])
        ->when($request->filled('currentFilter'), function($q) use($request, $timezone){
          $q->whereDate('created_at', '=', $request->input('currentFilter'));
        })
        ->when($request->filled('monthFilter'), function($q) use($request){
          $q->whereMonth('created_at', '=',$request->input('monthFilter'));
        })
        ->latest()
        ->paginate(10);
    
    if ($request->ajax()) {
      return view('store.reports.orders.list', compact('users', 'timezone', 'months'));
    }
    return view('store.reports.orders.index', compact('users', 'activePage', 'titlePage', 'timezone', 'months'));
  }

  public function exportCustomer(Request $request)
  {
    $activePage = 'reports';
    $titlePage = 'Order Reports';
    $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
    $months = [];
    for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
     $months[$m] = $month;
     }
    $users = Order::where(['store_id'=>$this->user->id])
        ->when($request->filled('currentFilter'), function($q) use($request, $timezone){
          $q->whereDate('created_at', '=', $request->input('currentFilter'));
        })
        ->when($request->filled('monthFilter'), function($q) use($request){
          $q->whereMonth('created_at', '=',$request->input('monthFilter'));
        })
        ->latest()->get()->toArray();
    
    return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($users)
          {

              $sheet->fromArray($users);
          });
    })->download($type);

    if ($request->ajax()) {
      return view('store.reports.orders.list', compact('users', 'timezone', 'months'));
    }
    return view('store.reports.orders.index', compact('users', 'activePage', 'titlePage', 'timezone', 'months'));
  }


}
