<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'promotion_percent' => $this->promotion_percent,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
