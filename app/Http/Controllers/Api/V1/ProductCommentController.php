<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductComment\StoreRequest;
use App\Http\Resources\Models\ProductCommentResource;
use App\Models\ProductComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductCommentController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return ProductCommentResource
     */
    public function store(StoreRequest $request)
    {
        $product_comment = ProductComment::query()->create(array_merge($request->validated(), [
            'user_id' => Auth::id(),
        ]));

        return new ProductCommentResource($product_comment);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProductCommentResource::collection(ProductComment::query()->where('user_id', Auth::id())->paginate());
    }

    /**
     * @param int $id
     * @return ProductCommentResource
     */
    public function show($id)
    {
        return new ProductCommentResource(ProductComment::query()->findOrFail($id));
    }

    /**
     * @param ProductComment $product_comment
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(ProductComment $product_comment)
    {
        if($product_comment->user_id != Auth::id())
            abort(403);

        $product_comment->delete();
        return response()->json();
    }
}
