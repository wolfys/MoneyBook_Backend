<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $field, string $operator, $value)
 * @method static create(array $array)
 * @property mixed $user_id
 */
class IncomeTransactions extends Model
{
    use HasFactory;

    protected $table = 'income_transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
      'user_id',
      'income_category_id',
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

    public function incomeCategory(): belongsTo
    {
        return $this->belongsTo(IncomeCategories::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
