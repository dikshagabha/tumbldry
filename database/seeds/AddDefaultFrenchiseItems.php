<?php

use Illuminate\Database\Seeder;

class AddDefaultFrenchiseItems extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([

        	['name'=>'Packaging Polybag' , 'type'=>11], 
        	['name'=>'Leaflets' , 'type'=>11], 
        	['name'=> 'Suit Cover', 'type'=>11], 
        	['name'=>'Shirt Card' , 'type'=>11], 
        	['name'=> 'Shirt Band	', 'type'=>11], 
        	['name'=> 'Brand Table', 'type'=>11], 
        	['name'=> 'Carry bag', 'type'=>11], 
        	['name'=> 'Tshirt', 'type'=>11], 
        	['name'=> 'Cap', 'type'=>11], 
        	['name'=> 'Laundry bag	', 'type'=>11], 
        	['name'=> 'Other packaging Material', 'type'=>11],
        	['name'=> 'Emulsifier', 'type'=>11],
        	['name'=> 'Detergent', 'type'=>11],
        	['name'=> 'Clax Magic', 'type'=>11],
        	['name'=> 'Oxy Bleach', 'type'=>11],
        	 
        ]);
    }
}
