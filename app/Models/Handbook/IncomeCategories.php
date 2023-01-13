<?php

namespace App\Models\Handbook;

use Illuminate\Database\Eloquent\Model;

class IncomeCategories extends Model
{
    protected $table = "hb__income_categories";

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i',
        'updated_at' => 'date:d.m.Y H:i'
    ];
}
