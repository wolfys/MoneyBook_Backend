<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $field, string $operator, $value)
 */
class Settings extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'balance_credit_card_full',
        'expend_category_main',
        'income_category_main',
        'expend_category_active',
        'income_category_active'
    ];

}
