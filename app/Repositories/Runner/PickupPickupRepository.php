<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
    UserJobs,
    PickupRequest
};

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

    public function getPickupJobs($request, $user)
    {
        $pickups = PickupRequest::where('assigned_to', $user->id)->latest()->paginate(10);

        $jobs = UserJobs::where('user_id', $user->id)->where('type', 1)->get();
        return ["message"=>"Pickup Found", "data"=>['pickups'=>$pickups, 'jobs'=>$jobs], 'http_status'=>200];
    }

    public function getPickupJobs($request, $user)
    {
        $jobs = UserJobs::where('user_id', $user->id)->where('type', 2)->get();
        return ["message"=>"Delivery Jobs", "data"=>$jobs], 'http_status'=>200];
    }
}
