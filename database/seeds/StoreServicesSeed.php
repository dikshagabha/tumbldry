<?php

use Illuminate\Database\Seeder;

class StoreServicesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            ['name' => 'Wash & Iron',
                        'type'=>1, 'form_type'=>2],
            ['name' => 'Wash & Fold',
                        'type'=>1, 'form_type'=>2],
            ['name' => 'Premium Laundry',
                        'type'=>1, 'form_type'=>2],
            ['name' => 'Ironing',
                        'type'=>1, 'form_type'=>2],

            ['name' => 'Dry Clean',
                        'type'=>1, 'form_type'=>1],
            ['name' => 'Shoe Cleaning',
                        'type'=>1, 'form_type'=>4],
            
            ['name' => 'Car Wash',
                        'type'=>1, 'form_type'=>3],
            
            ['name' => 'Sofa Cleaning',
                        'type'=>1, 'form_type'=>5],
            
            ['name' => 'Home Cleaning',
                        'type'=>1, 'form_type'=>6]

        ]);
    }
}
