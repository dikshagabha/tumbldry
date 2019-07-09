<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
    UserJobs,
    PickupRequest,
    Order
};
use App\Repositories\CommonRepository;
use App\Jobs\NotificationsUser as not;
use Pusher;
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

        $jobs = UserJobs::where('user_id', $user->id)->where(['type'=> 1])->with('store_details', 'order_details')->get();
        
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
        $jobs = PickupRequest::where('id', $id)->first();
        $jobs->status = 4;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>3]);
        

        if ($jobs->save()) {
          // Send Notification to store
          not::dispatch($jobs, 2);

           $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
              $options
            );


           $data['message'] = $jobs->runner_name." has canceled pickup ". $id .".";
           $push = $pusher->trigger('my-channel', 'notification'. $jobs->store_id, $data);
            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }

    public static function acceptRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->first();
        $jobs->status = 3;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>2]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($jobs, 3);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
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
        $jobs = PickupRequest::where('id', $id)->first();
        $jobs->status = 6;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>4]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($jobs, 4);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
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
        $jobs = PickupRequest::where('id', $id)->first();
        $jobs->status = 5;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>5]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($jobs, 5);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
              $options
            );

            $data['message'] = $jobs->runner_name." has recieved pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }

    public static function deliveredpickupRequest($request, $user, $id)
    {
        $jobs = PickupRequest::where('id', $id)->first();
        $jobs->status = 7;

        UserJobs::where('user_id', $user->id)->where(['type'=> 1])->where('order_id', $id)->update(['status'=>7]);
        $jobs->save();

        if ($jobs) {
          // Send Notification to store
          not::dispatch($jobs, 6);
          $options = array(
              'cluster' => 'ap2',
              'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
              '104302283d3c873072cc',
              'c5075016e7abb14b7a0e',
              '774754',
              $options
            );
            $data['message'] = $jobs->runner_name."has delivered pickup id=".$id.".";
            $pusher->trigger('my-channel', 'notification'.$jobs->store_id, $data);


            return ["message"=>"Pickup Details", "data"=>$jobs, 'http_status'=>200, 'http_status'=>200, 'code'=>1, 'msg'=>'Success','details'   =>[
                        'data'=>$jobs]
                    ];            
        }
        return ["message"=>"No Pickup Found!", "data"=>$jobs, 'http_status'=>400];
    }
}
