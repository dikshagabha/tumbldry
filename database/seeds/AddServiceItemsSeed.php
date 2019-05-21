<?php

use Illuminate\Database\Seeder;

class AddServiceItemsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
        	// Shoe Cleaning
            ['name' => 'Leather',
                        'type'=>4],
            ['name' => 'Suede',
                        'type'=>4],
            ['name' => 'Ankle',
                        'type'=>4],
            ['name' => 'Sports',
                        'type'=>4],
            ['name' => 'Boots',
                        'type'=>4],
            ['name' => 'Sandal',
                        'type'=>4],
            // Bag Cleaning
            ['name' => 'Compact SUV',
                        'type'=>3],
            ['name' => 'SUV',
                        'type'=>3],
            ['name' => 'Luxary',
                        'type'=>3],

            // Sofa Clean
            ['name' => 'Leather',
                        'type'=>5],
            ['name' => 'Fabric',
                        'type'=>5],

            // Home Clean
            ['name' => 'BHK',
                        'type'=>6],
            ['name' => 'Kitchen',
                        'type'=>6],
            ['name' => 'Bathroom',
                        'type'=>6],
 
        ]);
    }
}
