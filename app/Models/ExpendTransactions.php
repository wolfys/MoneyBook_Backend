<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $user_id
 * @method static where(string $string, string $string1, $id)
 * @method static create(array $array)
 */
class ExpendTransactions extends Model
{
    use HasFactory;

    protected $table = 'expend_transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'expend_category_id',
        'money',
        'date_transaction',
        'comment',
        'credit',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_transaction' => 'date:d.m.Y H:i',
    ];

    public function category(): belongsTo
    {
        return $this->belongsTo(ExpendCategories::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
