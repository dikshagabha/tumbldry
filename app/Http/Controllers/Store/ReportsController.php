<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\{
	Address,
	Location,
  Order,
  UserPayments,
  Service,
  UserFranchiseShare,
  Items
};
use Carbon\Carbon;
use App\User;
use Excel;
use App\Exports\SettlementExport;
class ReportsController extends Controller
{
  protected $user;
	protected $useraddress;
	protected $location;

  protected $gst;
  protected $cgst;
  //protected $gst;
  
	public function __construct(){
    $this->middleware(function($request, $next) {
        $this->user = Auth::user()->load('addresses');
        $this->useraddress = $this->user->addresses->first();
        $this->location = Location::where('pincode', $this->useraddress->pin)->first();

        $this->gst = 9;
        $this->cgst = 9;
        
        if ($this->user->gst) {
          $this->gst = 0;
          $this->cgst = 0;
          if ($this->user->gst->enabled) {
            $this->gst = $user->gst->gst;
            $this->cgst = $user->gst->cgst;
          }
        }

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
  			->get();
    
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
        ->get();
    
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
    //var_dump(extension_loaded('zip'));die;

        //dd(public_path('sheet.xlsx'));
//       $data = Excel::import(function($file){
//         foreach ($file->toArray() as $row) {
//                     print_r($row);
//                 }
//     }, public_path().'/sheet.xlsx');

//       Excel::load(public_path().'/sheet.xlsx', function($file) {

//     // modify stuff

// })->export('csv');

      //dd($data);

      return  Excel::download(new SettlementExport, 'sheet.xlsx');

      //dd($data);
    return;
    // if ($request->ajax()) {
    //   return view('store.reports.orders.list', compact('users', 'timezone', 'months'));
    // }
    // return view('store.reports.orders.index', compact('users', 'activePage', 'titlePage', 'timezone', 'months'));
  }

  public function ledger(Request $request){
    $activePage = 'reports';
    $titlePage = 'Accounting Reports';
    $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
    
    $months = [];
    for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
     $months[$m] = $month;
     }
    $users = UserPayments::where('to_id', $this->user->id)
              ->when($request->filled('currentFilter'), function($q) use($request, $timezone){
                  $q->whereDate('created_at', '=', $request->input('currentFilter'));
                })
                ->when($request->filled('monthFilter'), function($q) use($request){
                  $q->whereMonth('created_at', '=',$request->input('monthFilter'));
                })
                ->latest()
                ->get();

    
    
    if ($request->ajax()) {
      return view('store.reports.accounting.ledger.list', compact('users', 'timezone', 'months'));
    }
    
    return view('store.reports.accounting.ledger.index', compact('users', 'activePage', 'titlePage', 'timezone', 'months'));
  
  }

  public function settlement(Request $request){
    $activePage = 'reports';
    $titlePage = 'Settlement Reports';
    $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
    
    
      $month = Carbon::now()->month-1;
      $payments = UserPayments::where('to_id', $this->user->id)->with('order')
                  ->whereIn('type', [1, 5])
                  ->when($request->filled('start_date'), function ($q) use($request){
                      $q->where('created_at', '>=',$request->input('start_date'));
                  })
                  ->when($request->filled('end_date'), function ($q) use($request){
                      $q->where('created_at', '<=',$request->input('end_date'));
                  })
                  ->get();
      
      $services = Service::get();
      $laundary = $services->where('form_type', 2)->where('type', 1)->pluck('id');
      $dryclean =  $services->where('form_type', 1)->where('type', 1)->pluck('id');
      $other =  $services->wherenotIn('form_type', [1, 2])->where('type', 1)->pluck('id');


      $A=$B=$C=0;
     // echo "<pre>";
      //
      foreach ($payments as $key => $value) {
        $order = $value->order;
        
         //print_r($value->toArray());
        if (!$order) {
          continue;    
        }

       
        if (in_array($order->service_id, $laundary->toArray())) {
          $A+=$value->price;
        }
        if (in_array($order->service_id, $dryclean->toArray())) {
          $B+=$value->price;
        }
        if (in_array($order->service_id, $other->toArray())) {
          $C+=$value->price;
        }
      }
     // die;
      $D = $payments->where('type', '1')->sum('price');
      $E = $payments->where('type', '5')->sum('price'); 
      
      $shares = UserFranchiseShare::where('user_id', $this->user->id)->first();
      $items  = Items::where('type', 11)->get();

      $payments = UserPayments::whereIn('order_id', $items->pluck('id'))
                  ->where('user_id', $this->user->id)
                  ->where('type', 51)
                  ->when($request->filled('start_date'), function ($q) use($request){
                      $q->where('created_at', '>=',$request->input('start_date'));
                  })
                  ->when($request->filled('end_date'), function ($q) use($request){
                      $q->where('created_at', '<=',$request->input('end_date'));
                  })->get();

      $total_billing = $payments->sum('price');
      if (!$shares) {
        $shares = UserFranchiseShare::where('user_id', 0)->first();
      }

      $gst = $this->gst;
      $cgst = $this->cgst;

      if ($request->ajax()) {
        return view('store.reports.settlement.list', compact('users', 'A', 'B', 'C', 'D','E', 'shares', 'items', 'payments',
      'total_billing', 'gst', 'cgst'));
      }
      
      return view('store.reports.settlement.index', compact('users', 'activePage', 'titlePage', 'A', 'B', 'C', 'D','E',  'shares', 'items', 'payments', 'total_billing' , 'gst', 'cgst')); 
  }

}
