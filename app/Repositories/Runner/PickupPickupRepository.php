<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use 

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
        $oickups = PickupRequest::where('assigned_to', $user->id)->latest()->paginate(10);

        return ["message"=>"Pickup Found", "data"=>$oickups, 'http_status'=>200];
    }
}
