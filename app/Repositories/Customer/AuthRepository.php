<?php

namespace App\Repositories\Customer;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\User;
use App\Model\Address;
use DB;
use Auth;
use App\Repositories\CommonRepository;
use JWTAuth;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

use App\Model\Otp;
/**
 * Class HomeRepository.
 */
class HomeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    

}
