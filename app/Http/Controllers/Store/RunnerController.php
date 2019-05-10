<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\PickupRequest;
use Auth;
use App\Repositories\Runner\HomeRepository;

use Mail;
use App\Mail\Runner\SendPassword;

use App\Http\Requests\Runner\Auth\RegisterRequest;
use App\Http\Requests\Runner\Auth\UpdateRequest;

class RunnerController extends Controller
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
      $activePage = 'runner';
      $titlePage  = 'Runner Details';
      $users = User::where('role', 5)->where('user_id', Auth::user()->id)
              ->when($request->filled('search'), 
                function($query) use($request) {
                  $query->where(function($q) use($request) {
                    $q->where('name', 'like', '%' . $request->input('search') . '%')
                          ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                          ->orWhere('phone_number', 'like', '%' . $request->input('search') . '%');
                    
                  });
                })->when(($request->filled('sort_type') && in_array($request->input('sort_type'), [0, 1])), function($query) use($request) {
                $query->where('status', $request->input('sort_type'));
               })
               ->latest()->paginate(10);
      if ($request->ajax()) {
        //dd($users);
        return view('store.manage-runner.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('store.manage-runner.index', compact('users', 'activePage', 'titlePage'));
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

      return view('store.manage-runner.create', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
      $response = HomeRepository::store($request, Auth::user()->id);
      $http_status = $response['http_status'];
      unset($response['http_status']);
      return response()->json($response, $http_status); 
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

      if($delete){
        return response()->json(["message"=>"Runner Assigned!"], 200);
      }
      return response()->json(["message"=>"Something went wrong!"], 400);
    }
}
