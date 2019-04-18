<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Auth;
class Helper
{
    public static function userImage()
    {
      if (Auth::user()->image) {

        return Auth::user()->image;
        // code...
      }

        return asset('images/user.png');
    }
}
