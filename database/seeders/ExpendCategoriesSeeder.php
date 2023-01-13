<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpendCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Продукты',
            'Бытовая химия',
            'Косметика',
            'Текстиль',
            'Одежда',
            'Обувь',
            'Еда на заказ',
            'Кафе',
            'Транспорт',
            'Связь',
            'Аренда',
            'Коммуналка',
            'Кредит',
            'Кредитная карта',
            'Кино',
            'Игры',
            'Театры',
            'Парк',
            'На подарок',
            'На ремонт',
            'Красота',
            'Здоровье',
            'Электроника',
            'Мебель',
            'Сервер',
            'Подписки',
            'Дал в долг',
            'Книги',
            'В Кубышку',
            'Алкоголь',
            'Вкусняшки',
            'Столовая',
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

        \DB::table('expend_categories')->insert($data);

        \DB::table('expend_categories')->insert([
           'name' => 'Шоколадки',
           'user_id' => 1,
           'created_at' => now(),
           'updated_at' => now()
        ]);
    }
}
