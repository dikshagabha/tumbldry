<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\PickupRequest;
use App\Model\Address;
use App\User;
use Auth;
use App\Notifications\StoreNotifications;

class HomeController extends Controller
{
    public function index(Request $Request)
    {

    	$activePage = 'dashboard';
    	$titlePage = "Dashboard";
     	
    	$users = PickupRequest::where('store_id', Auth::user()->id)->latest()->paginate(10);
    	if ($Request->ajax()) {
    		return view('store.pickup-requests.list', compact('users', 'activePage', 'titlePage'));
    	}
    	
    	return view('store.pickup-requests.index', compact('users', 'activePage', 'titlePage'));
    }

    public function getcustomerdetails(Request $Request, $id)
    {
       
        $user = User::where("id", $id)->first();

        return view('store.customer_details_modal', compact('user'));
    }

    public function getaddressdetails(Request $Request, $id)
    {
       
        $user = Address::where("id", $id)->first();

        return view('store.address_details_modal', compact('user'));
    }
}
