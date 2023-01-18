<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $active
 * @property mixed $created_at
 * @property mixed $updated_at
 *   @property mixed $user_id
 */
class CategoriesResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => !(($this->user_id === null)),
            'created_date' => ($this->updated_at === null) ? $this->convertDate($this->created_at)
                : $this->convertDate($this->updated_at),
        ];
    }

    private function convertDate($date): string
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }
}
