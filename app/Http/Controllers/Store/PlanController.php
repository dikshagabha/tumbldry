<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\UserPlan;
use App\Model\Plan;
use Auth;
use App\Repositories\Runner\HomeRepository;

use Mail;
use App\Mail\Runner\SendPassword;

use App\Http\Requests\Runner\Auth\RegisterRequest;
use App\Http\Requests\Runner\Auth\UpdateRequest;
use DB;
use Carbon\Carbon;
class PlanController extends Controller
{

    protected $user;
    public function __construct(){

          // if the user is logged in then fetches the details of the user
          $this->middleware(function($request, $next) {
              $this->user = Auth::user();
              return $next($request);
          });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $activePage = 'plans';
      $titlePage  = 'Plan';
      $users = UserPlan::where('store_id', $this->user->id)
               ->latest()->paginate(10);

      if ($request->ajax()) {
        //dd($users);
        return view('store.manage-plans.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('store.manage-plans.index', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $activePage = 'runner';
      $titlePage  = 'Create Runner';
      $plan_types  = ['1'=>'Membership Plan'];
      return view('store.manage-plans.create', compact('users', 'activePage', 'plan_types','titlePage'));
    }

    public function getPlans(Request $request){

      $plans = Plan::where('type', $request->input('type'))->get();
      //dd($plans);
      if ($plans) {
        return response()->json(['message'=>'Plans Found', 'view'=>view('store.manage-plans.plans', compact('plans'))->render()], 200);
   
      }

      return response()->json(['message'=>'No Plans Found', 'view'=>view('store.manage-plans.plans', compact('plans'))], 400);
   
       }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate(['customer_id'=>'bail|nullable|numeric',
                          'name'=>'bail|required|string',
                          'email'=>'bail|nullable|string',
                          'phone_number'=>'bail|required|string|min:10|max:12',
                          'plan'=>'bail|required|numeric',
                          //'plan_types'=>'bail|required|numeric'
                        ]);
      if ($request->input('customer_id')) 
      {
        $customer_id = $request->input('customer_id');
      }else{
        $user = User::create(['name'=>$request->input('name'), 
                  'email'=>$request->input('email'),
                  'phone_number'=>$request->input('phone_number'),  
                  'role'=> 4
                  ]);
        $customer_id = $user->id;
      }

      $plan = Plan::where('id', $request->input('plan'))->first();

      $valid_to = null;
      if ($plan->end_date==1) {
        $valid_to=Carbon::now()->addWeek(1);
      }
      
      if ($plan->end_date==2) {
        $valid_to=Carbon::now()->addMonth(1);
      }

      if ($plan->end_date==3) {
        $valid_to=Carbon::now()->addYear(1);
      }
      
      $plans = UserPlan::create(['user_id'=>$customer_id, 'store_id'=>$this->user->id, 'valid_from'=>Carbon::now(), 
                        'plan_id'=>$request->input('plan'), 'valid_to'=>$valid_to]);

      // $wallet = UserWallet::where('user_id', $customer_id)->first();
      // if (!$wallet) {
      //   $wallet = UserWallet::create(['user_id'=>$customer_id])
      // }
      // $wallet->price= $wallet->price+$plan->price;
      // $wallet->save();

      //dd(route('plans.payment',$plans->id ));
      if ($plans) {
        return response()->json(["message"=>"Plan Added!", 'redirectTo'=>route('plans.payment', $plans->id)], 200);
      }

      return response()->json(["message"=>"Something Went Wrong"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);

       $user = User::where("id", $id)->first();
      // $data = StoreFields::whereIn('id', [$user->machine_type, $user->boiler_type])->get();
       return view("store.manage-runner.show", compact('user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $activePage = 'runner';
      $titlePage  = 'Edit Runner';

      $user = User::where("id", decrypt($id))->first();
      
      return view('store.manage-runner.edit', compact('user', 'id','activePage', 'titlePage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $id = decrypt($id);
      $response = HomeRepository::update($request, $id);
      $http_status = $response['http_status'];
      unset($response['http_status']);
      return response()->json($response, $http_status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $delete = User::where(['id'=>decrypt($id)])->delete();
      if ($delete) {
        return response()->json(["message"=>"Store deleted!"], 200);
      }
      return response()->json(["message"=>"Something went wrong !"], 400);
    }

    public function status(Request $request, $id)
    {
      $delete = User::where(['id'=>$id])->update($request->only('status'));
      if($delete){
        return response()->json(["message"=>"Store updated!"], 200);
      }
      return response()->json(["message"=>"Something went wrong!"], 400);
    }

    public function assignRunner(Request $request)
    {
         $delete = PickupRequest::where(['id'=>$request->input('id')])->update(['assigned_to'=>$request->input('assigned_to'), 'status'=>2]);
          $job = UserJobs::create(["order_id"=>$request->input('id'), 'type'=>1, 'user_id'=>$request->input('assigned_to'), 'assigned_by'=>$this->user->id]);
          if($delete){
            return response()->json(["message"=>"Runner Assigned!"], 200);
          }
          return response()->json(["message"=>"Something went wrong!"], 400);
       
    }


}
