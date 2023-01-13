<?php

namespace App\Models\Handbook;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $field, string $operator, $null)
 * @method static create(array $array)
 * @method static find($id)
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
