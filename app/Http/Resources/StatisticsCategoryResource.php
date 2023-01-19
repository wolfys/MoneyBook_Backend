<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $category
 * @property mixed $sum
 */
class StatisticsCategoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'category_name' => $this->category->name,
            'money' =>  number_format($this->sum, 0, '', ' ')
        ];
    }
}
