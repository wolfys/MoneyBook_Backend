<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $field, string $operator, $value)
 * @method static create(array $array)
 * @property mixed $user_id
 */
class ExpendCategories extends Model
{

    protected $table = "hb__expend_categories";

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i',
        'updated_at' => 'date:d.m.Y H:i'
    ];


}