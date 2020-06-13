<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\CategoryResource;
use App\Http\Resources\Models\ProductResource;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::query()->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ProductResource
     */
    public function show($id)
    {
        $response = new ProductResource(Product::with('comments')->findOrFail($id));
        $response->showComment();
        return $response;
    }

    /**
     * @return ProductResource
     */
    public function recommendation()
    {
        // Best already buy product
        $products_already_buy = TransactionProduct::with(['transaction' => function ($query) {
            $query->where('user_id', Auth::id());
        }, 'product'])
            ->select(['product_id'], DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderBy(\DB::raw('count(*)', 'DESC'))
            ->limit(5);

        // Best product in this moment
        $products_best_selling = TransactionProduct::with('product')
            ->select(['product_id'], DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderBy(\DB::raw('count(*)', 'DESC'))
            ->limit(5);

        // Merge request
        $products = $products_already_buy->unionAll($products_best_selling)->get();

        // Check if they have promotion
        $promotions = Promotion::query()
            ->where('start_at', '<', Carbon::now())
            ->where('end_at', '>', Carbon::now())
            ->get();
        $products_with_promotion = [];
        foreach($products as $product) {
            foreach($promotions as $promotion) {
                if($product->product->category_id == $promotion->category_id) {
                    array_push($products_with_promotion, $product->product);
                    break;
                }
                if($product->product_id == $promotion->product_id) {
                    array_push($products_with_promotion, $product->product);
                    break;
                }
            }
        }

        if(count($products_with_promotion) > 0) {
            $product = $products_with_promotion[rand(0,count($products_with_promotion)-1)];
            $response = new ProductResource($product);
            $response->showPromotion();
            return $response;
        } else {
            $product = $products[rand(0,count($products)-1)];
            return new ProductResource($product);
        }
    }
}
