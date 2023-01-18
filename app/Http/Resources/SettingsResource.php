<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $balance_credit_card_full
 * @property mixed $expend_category_main
 * @property mixed $income_category_main
 * @property mixed $expend_category_active
 * @property mixed $income_category_active
 * @property mixed $dark_mode
 */
class SettingsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'balance_credit_card_full' => $this->balance_credit_card_full,
            'expend_category_main' => json_decode($this->expend_category_main),
            'income_category_main' => json_decode($this->income_category_main),
            'expend_category_active' => json_decode($this->expend_category_active),
            'income_category_active' => json_decode($this->income_category_active),
            'dark_mode' => $this->dark_mode,
        ];
    }
}
