<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Model\Address;
class AddStoreSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =User::create([
            'name' => str_random(6),
            'email' => 'teststore@yopmail.com',
            'password' => bcrypt('test@123'),
            'role'=>3,
            'phone_number'=>"1231231234",
            'api_token'=>Str::random(60)api_token
        ]);


        Address::create([
            'address' => "Test Address",
            'user_id' => $user->id,
            'pin' => "123123",
            'state'=>'Test State',
            'city'=>'Test City',
            
        ]);

    }
}
