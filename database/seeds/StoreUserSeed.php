<?php

use Illuminate\Database\Seeder;

class StoreUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(6),
            'email' => 'test@yopmail.com',
            'password' => bcrypt('test@123'),
            'role'=>1
        ]);

    }
}
