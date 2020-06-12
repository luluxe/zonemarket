<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public $show_comment = false;

    public function showComment()
    {
        $this->show_comment = true;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ];

        if($this->show_comment) {
            $data = array_merge($data, ['comments' => ProductCommentResource::collection($this->comments)]);
        }

        return $data;
    }
}
