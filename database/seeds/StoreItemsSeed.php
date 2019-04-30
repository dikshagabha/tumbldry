<?php

use Illuminate\Database\Seeder;

class StoreItemsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            ['name' => 'Women Suit',
                        'type'=>1],
            ['name' => 'Women Suit Ethnic Plain',
                        'type'=>1],
            ['name' => 'Women Suit Formal/Western',
                        'type'=>1],

            ['name' => 'Laundary (1kg)',
                        'type'=>2],

            ['name' => 'HatchBack',
                        'type'=>3],
            ['name' => 'Sedan',
                        'type'=>3],
            ['name' => 'Compact SUV',
                        'type'=>3],
            ['name' => 'SUV',
                        'type'=>3],
            ['name' => 'Luxary',
                        'type'=>3],
        ]);
    }
}
