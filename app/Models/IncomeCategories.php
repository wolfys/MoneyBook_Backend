<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $field, string $operator, $value)
 * @method static create(array $array)
 * @method static orderBy(string $field, string $order)
 * @property mixed $user_id
 */
class IncomeCategories extends Model
{
    protected $table = "income_categories";

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i',
        'updated_at' => 'date:d.m.Y H:i'
    ];
}
