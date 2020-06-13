<?php

namespace App\Http\Resources\Models;

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public $show_comment = false;
    public $show_promotion = false;

    public function showComment()
    {
        $this->show_comment = true;
    }

    public function showPromotion()
    {
        $this->show_promotion = true;
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

        if($this->show_promotion) {
            $promotion = Promotion::query()
                ->where('category_id', $this->category_id)
                ->where('start_at', '<', Carbon::now())
                ->where('end_at', '>', Carbon::now())
                ->orWhere('product_id', $this->product_id)
                ->where('start_at', '<', Carbon::now())
                ->where('end_at', '>', Carbon::now())
                ->first();
            $data = array_merge($data, ['promotion' => new PromotionResource($promotion)]);
        }

        return $data;
    }
}
