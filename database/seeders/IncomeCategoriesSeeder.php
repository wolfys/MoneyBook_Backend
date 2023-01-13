<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IncomeCategoriesSeeder extends Seeder
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

        \DB::table('hb__income_categories')->insert($data);
    }
}
