<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id' => $this->id,
            'base_amount' => $this->base_amount,
            'amount' => $this->amount,
            'items' => TransactionProductResource::collection($this->products),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
