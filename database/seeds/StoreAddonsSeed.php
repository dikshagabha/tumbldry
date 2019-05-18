<?php

use Illuminate\Database\Seeder;

class StoreAddonsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            ['name' => 'Spot Cleaning',
                        'type'=>2, 'form_type'=>2],
            ['name' => 'Individual Packing',
                        'type'=>2, 'form_type'=>2],
            ['name' => 'Buttoning',
                        'type'=>2, 'form_type'=>2],

            ['name' => 'Hanger',
                        'type'=>2, 'form_type'=>1],

            ['name' => 'Fold',
                        'type'=>2, 'form_type'=>1],
           
           
        ]);
    }
}
