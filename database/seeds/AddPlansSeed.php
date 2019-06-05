<?php

use Illuminate\Database\Seeder;

class AddPlansSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('plans')->insert(
    		[[
	    		'name'=>'Weekly',
	    		'description'=>'Rs 500 in wallet valid for one week.',
	    		'price'=>500,
	    		'type'=>1, 'end_date'=>1
	    	],
    		[
	    		'name'=>'Monthly',
	    		'description'=>'Rs 2000 in wallet valid for one month.',
	    		'price'=>2000,
	    		'type'=>1, 'end_date'=>2
    		],
    		[
	    		'name'=>'Yearly',
	    		'description'=>'Rs 5000 in wallet valid for one year.',
	    		'price'=>5000,
	    		'type'=>1, 
	    		'end_date'=>3
    		]
    	]);
    }
}
