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
	public function __construct(){
	}

    public function markRead(Request $Request){
    	
        $not = Notification::where("to_id", Auth::user()->id)->update(["read_at"=>Carbon::now()]);
        
    	return response()->json(["message"=>"Notifications updated"], 200);

    }


}
