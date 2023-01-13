<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
           'name' => 'Илья',
           'second_name' => 'Платонов',
           'last_name' => 'Владимирович',
           'email' => 'example@ge-world.ru',
           'email_verified_at' => now(),
           'password' => bcrypt('123123'),
           'created_at' => now()
        ]);


        // Token: 1|CFsX5BELU48axCJlD4z9tqysc1hu4LSuniv5T2rA

        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => 1,
            'name' => 'example@ge-world.ru',
            'token' => '8f1609cd4cf65677bc2dd5deec8d86fb7bc374b7402c03c998ed931cbfeba421',
            'abilities' => '["*"]',
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}
