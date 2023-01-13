<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $user
 * @property mixed $category_id
 * @property mixed $incomeCategory
 * @property mixed $money
 * @property mixed $comment
 * @property mixed $credit
 */
class TransactionsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => getUserInitials($this->user->name,  $this->user->last_name,  $this->user->second_name),
            'category_id' => $this->category_id,
            'category_name' => $this->incomeCategory->name,
            'money' => $this->money,
            'comment' => $this->comment,
            'credit' => $this->credit,
        ];
    }
}
