<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $user
 * @property mixed $category_id
 * @property mixed $money
 * @property mixed $comment
 * @property mixed $credit
 * @property mixed $category
 * @property mixed $date_transaction
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
            'category_name' => $this->category->name,
            'date_transaction' => Carbon::parse($this->date_transaction)->format('d.m.Y'),
            'money' => $this->money,
            'comment' => $this->comment,
            'credit' => $this->credit,
        ];
    }
}
