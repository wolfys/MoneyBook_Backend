<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {


        $income = [1,2,3,4,5,6,7];

        $expend = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32];

        \DB::table('settings')->insert([
           'user_id' => 1,
           'balance_credit_card_full' => 150000,
           'expend_category_main' => json_encode($expend),
           'income_category_main' => json_encode($income),
           'expend_category_active' => json_encode($expend),
           'income_category_active' => json_encode($income),
           'created_at' => now(),
           'updated_at' => now()
        ]);
    }
}
