<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /*
    public function store()
    {
        return new TransactionResource();
    }
    */

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

    /*
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
    }
    */
}
