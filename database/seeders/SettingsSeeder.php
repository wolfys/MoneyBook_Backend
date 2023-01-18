<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {

        $expend_category_main = [
          1, 2, 3, 6
        ];

        \DB::table('settings')->insert([
           'user_id' => 1,
           'balance_credit_card_full' => 150000,
           'expend_category_main' => json_encode($expend_category_main),
           'income_category_main' => json_encode($expend_category_main),
           'expend_category_active' => json_encode($expend_category_main),
           'income_category_active' => json_encode($expend_category_main),
           'created_at' => now(),
           'updated_at' => now()
        ]);
    }
}
