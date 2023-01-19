<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IncomeCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Зарплата',
            'Стрим',
            'Заказ',
            'Подарок',
            'Возрат Долга',
            'Из Кубышки',
            'С Кредитной карты',
        ];

        $data = [];

        $i = 0;

        foreach ($categories as $category) {
            $data[$i]['name'] = $category;
            $data[$i]['user_id'] = null;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $i++;
        }

        \DB::table('income_categories')->insert($data);
    }
}
