<?php

use Illuminate\Database\Seeder;

class StoreFieldsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_fields')->insert([
            ['name' => 'Machine 1',
                        'type'=>1],
            ['name' => 'Machine 2',
                        'type'=>1],
            ['name' => 'Machine 3',
                        'type'=>1],
            ['name' => 'Machine 4',
                        'type'=>1],
            ['name' => 'Machine 5',
                        'type'=>1],
                         ['name' => 'Boiler 1',
                        'type'=>2],
            ['name' => 'Boiler 2',
                        'type'=>2],
            ['name' => 'Boiler 3',
                        'type'=>2],
            ['name' => 'Boiler 4',
                        'type'=>2],
            ['name' => 'Boiler 5',
                        'type'=>2],
            
        ]);
    }
}
