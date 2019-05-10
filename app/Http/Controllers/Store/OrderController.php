<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Notification;
use App\Http\Requests\Store\LoginRequest;
use Carbon\Carbon;

class NotificationsController extends Controller
{
	protected $user;
	public function __construct(){

        // if the user is logged in then fetches the details of the user
        $this->middleware(function($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
	}

    public function create(Request $Request){
    	$services = Services::where(['status'=>1, "type"=>1])->get();

    	return view("store.manage-order.create", compact('services'));
    }


}
