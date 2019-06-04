<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

use App\Model\Token;
use App\User;
use App\Model\Address;
/**
 * Class CommonRepository.
 */
class CommonRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function random_str($length=8, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
	}

    public static function getManageToken($token, $user_id): Token
    {
        return $token_get = Token::updateOrCreate(['user_id' => $user_id], ['token' => $token]);
    }

    public static function sendmessage($user, $message)
    {
        $url = 'http://push.sanketik.net//api/push?accesskey=jzzUlHL4NqhWs6VHzmUkGkYTaQKD7T&to='.$user.'&text='.$message.'&from=TBLDRY';

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         $response = curl_exec ($ch);
         $err = curl_error($ch);  //if you need
         curl_close ($ch);
         
         //dd($response);

         if ($response) {
            $response = json_decode($response);
            $array = get_object_vars($response);
         }
         return $response;
    }

     public static function search_vendor($address, $service){
        $pin = Address::where('id', $address)->first();
        $pin = $pin->pin;
        //dd($pin);
        $users = User::where('role', 6)->where('service_id', $service)->where('status', 1)
                 ->whereHas('addresses', function($q) use($pin){
                    $q->where('pin', $pin);
                })
                ->with('addresses')->get();
        //dd($users);
        return $users;
    }   

}
