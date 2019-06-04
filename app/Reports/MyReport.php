<?php
namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\processes\Filter;
use \koolreport\processes\TimeBucket;
use \koolreport\processes\Group;
use Auth;
use \koolreport\processes\Limit;
use \koolreport\inputs\Bindable;
use \koolreport\inputs\POSTBinding;
class MyReport extends \koolreport\KoolReport
{
    //use \koolreport\laravel\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Laravel
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.
    public function settings()
    {
        return array(
             'assets' => array(
                    'path' => public_path(),
                    'url' => '',
                ),
            "dataSources"=>array(
                "sales"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=tumbldry",
                    "username"=>"root",
                    "password"=>"diksha",
                    "charset"=>"utf8"
                )
            )
        );
    }

    function setup()
    {
        $user = Auth::user()->id;

        //dd($user);
        $this->src("sales")
        ->query("SELECT id,  name, created_at FROM users where user_id=". $user. ' AND role = 4 ')
        //  ->pipe(new TimeBucket(array(
        //     "created_at"=>"month"
        // )))
        ->pipe($this->dataStore("users"));
    }
}