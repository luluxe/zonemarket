<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\TransactionResource;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * @return TransactionResource
     */
    public function store()
    {
        // Create transaction
        $transaction = factory(Transaction::class)->create([
            'user_id' => Auth::id(),
        ]);

        // Add some product
        $transaction->products()->saveMany(factory(TransactionProduct::class, rand(1, 20))->create([
            'transaction_id' => $transaction->id,
        ]));

        // Fix amount of transaction
        foreach ($transaction->products as $product) {
            $transaction->base_amount += $product->base_amount * $product->quantity;
            $transaction->amount += $product->amount * $product->quantity;
        }
        $transaction->save();

        return new TransactionResource($transaction);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::query()->where('user_id', Auth::id())->paginate(5));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TransactionResource
     */
    public function show($id)
    {
        return new TransactionResource(Transaction::query()->where('user_id', Auth::id())->findOrFail($id));
    }

    /**
     * @param Transaction $transaction
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Transaction $transaction)
    {
        if($transaction->user_id != Auth::id())
            abort(401);

        foreach($transaction->products as $product)
            $product->delete();
        $transaction->delete();
        return response()->json();
    }
}
