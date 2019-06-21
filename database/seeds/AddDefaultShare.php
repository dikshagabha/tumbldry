<?php

use Illuminate\Database\Seeder;

class AddDefaultShare extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('user_franchise_shares')->insert([
            ['user_id' => 0,
                         'type'=>1, 'percent'=>93.5],
           ['user_id' => 0,
                         'type'=>2, 'percent'=>20],
           ['user_id' => 0,
                         'type'=>3, 'percent'=>20],
        ]);
    }
}
