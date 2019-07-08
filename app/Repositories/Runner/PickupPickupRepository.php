<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
    UserJobs,
    PickupRequest,
    Order
};
use App\Repositories\CommonRepository;

/**
 * Class PickupPickupRepository.
 */
class PickupPickupRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function getPickupJobs($request, $user)
    {
        //$pickups = PickupRequest::where('assigned_to', $user->id)->latest()->paginate(10);

        $jobs = UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('status', '!=', )->with('store_details', 'order_details')->get();
        
        if ($jobs) {
            return ["message"=>"Pickup Found", "data"=>$jobs, 'http_status'=>200, 'code'=>1, 'msg'=>'Success', 'details'=>[
                        'data'=>$jobs]];
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400, 'code'=>2, 'msg'=>'Error',];
    }

    public static function getDeliveryJobs($request, $user)
    {
        $jobs = UserJobs::where('user_id', $user->id)->where(['type'=> 2])->with('store_details', 'order_details')->get();
        if ($jobs) {
            return ["message"=>"Delivery Jobs", "data"=>$jobs, 'http_status'=>200, 
                    'code'=>1, 'msg'=>'Success','details'=>['data'=>$jobs] 
                    ];
        }
        return ["message"=>"No Jobs Found!", "data"=>$jobs, 'http_status'=>400 ,'http_status'=>200, 
                    'code'=>1, 'msg'=>'Success','details'=>[
                        'data'=>$jobs]
                    ];
    }

    public static function getPickupDetails($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->first();
        if ($jobs) {
            return ["message"=>"Pickups", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'=>[
                        'data'=>$jobs]];
        }
        return ["message"=>"No Pickups Found!", "data"=>$jobs, 'http_status'=>400, 'http_status'=>200, 'code'=>2, 'msg'=>'Error'];
    }

    public static function getOrderDetails($request, $user, $id)
    {
        $jobs = Order::where('id', $id)->with('items')->first();
        if ($jobs) {
            return ["message"=>"Order Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'=>[
                        'data'=>$jobs]];
        }
        return ["message"=>"No Order Found!", "data"=>$jobs, 'http_status'=>400];
    }

    public static function getLastOrderDetails($request, $user, $id)
    {
        $jobs = Order::where('customer_id', $id)->with('items')->latest()->first();
        if ($jobs) {
            return ["message"=>"Order Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'=>[
                        'data'=>$jobs]];
        }
        return ["message"=>"No Order Found!", "data"=>$jobs, 'http_status'=>400];
    }


    public static function cancelRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->get();
        $jobs->status = 4;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>3]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              env('PUSHER_APP_KEY'),
              env('PUSHER_KEY'),
              env('PUSHER_APP_ID'),
              $options
            );


            $data['message'] = $jobs->runner_name." has canceled pickup". $id .".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }

    public static function acceptRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->get();
        $jobs->status = 3;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>2]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              env('PUSHER_APP_KEY'),
              env('PUSHER_KEY'),
              env('PUSHER_APP_ID'),
              $options
            );


            $data['message'] = $jobs->runner_name." accepted pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);
            CommonRepository::sendmessage($jobs->customer_phone, 'Runner is out for pickup for id'.$id );

            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }
    public static function outforpickupRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->get();
        $jobs->status = 5;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>4]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              env('PUSHER_APP_KEY'),
              env('PUSHER_KEY'),
              env('PUSHER_APP_ID'),
              $options
            );
            $data['message'] = $jobs->runner_name." is out for pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }
    public static function recievedrunnerpickupRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->get();
        $jobs->status = 6;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>5]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              env('PUSHER_APP_KEY'),
              env('PUSHER_KEY'),
              env('PUSHER_APP_ID'),
              $options
            );
            $data['message'] = $jobs->runner_name." is out for pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }

    public static function deliveredpickupRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->get();
        $jobs->status = 7;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>7]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($pickup, 1);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              env('PUSHER_APP_KEY'),
              env('PUSHER_KEY'),
              env('PUSHER_APP_ID'),
              $options
            );


            $data['message'] = $jobs->runner_name." is out for pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }
}
