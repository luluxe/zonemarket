<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreditCardRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return LoginResource
     */
    public function store(StoreRequest $request)
    {
        $user = new User(array_merge($request->validated(), [
            'password' => bcrypt($request->password),
        ]));
        $user->save();

        return new LoginResource($user);
    }

    /**
     * The user is on the store
     * @param Request $request
     * @return UserResource
     */
    public function visit(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->visited_at = Carbon::now();
        $user->save();

        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        return response()->json();
    }

    /**
     * Add credit card detail
     * @param CreditCardRequest $request
     * @return UserResource
     */
    public function creditCard(CreditCardRequest $request)
    {
        $user = Auth::user();
        $user->credit_card = $request->credit_card;
        $user->save();

        return new UserResource($user);
    }
}
